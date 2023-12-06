<?php

namespace App\Repositories;

use App\Imports\PpdbRegistrationImport;
use App\Models\PpdbBpmsProvenFile;
use App\Models\PpdbRegistration;
use App\Models\PpdbRegistrationProvenFile;
use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\StudentPpdbRegistration;
use App\Models\StudentUpgradeHistory;
use App\Models\UserParent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PpdbRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "jenis_pendaftaran" => 'required',
                "gelombang_pendaftaran" => 'required',
                "jenjang" => 'required',
                "jalur_pendaftaran" => 'required',
                "nama_lengkap" => 'required',
                "nomor_induk_kependudukan" => 'required',
                "jenis_kelamin" => 'required',
                "tempat_lahir" => 'required',
                "tanggal_lahir" => 'required',
                "nama_ayah" => 'required',
                "nama_ibu" => 'required',
                "telepon_ayah" => 'required',
                "telepon_ibu" => 'required',
                "kelurahan" => 'required',
                "kecamatan" => 'required',
                "kota_atau_kabupaten" => 'required',
                "provinsi" => 'required',
                "kewarganegaraan" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-S: " . collect($validator->errors()->all())->implode(" , "));

            $jenjangs = jenjangData();
            $code = "";
            foreach ($jenjangs as $key => $jenjang) {
                if ($jenjang === $data['jenjang']) {
                    $code = $key;
                    break;
                }
            }

            if (isset($data['id'])) {
                $ppdbRegis = PpdbRegistration::find($data['id']);
                if (!$ppdbRegis) return resultFunction("Err code PR-S: data pendaftaran tidak ditemukan ");

                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['deleted_at']);
                unset($data['student_ppdb_registration']);
                unset($data['proven_pendaftaran']);
                unset($data['proven_bpms']);
                unset($data['id']);

                PpdbRegistration::where('id', $ppdbRegis->id)->update($data);

            } else {
                $ppdbHistory = PpdbRegistration::where('nomor_pendaftaran', 'LIKE', '%' . $code . '-'.date("Y").'%')->count();
                $nomorPendaftaran = $code . '-' . date("Y") . "-" . ($ppdbHistory+1);
                $data['nomor_pendaftaran'] = $nomorPendaftaran;
                $data['status_pendaftaran'] = 'menunggu verifikasi data';
                $data['status_pembayaran'] = '-';
                $ppdbRegis = PpdbRegistration::create($data);
            }

            return resultFunction("", true, $ppdbRegis);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }

    public function detail($nomorPendaftaran) {
        try {
            $ppdbRegistration = PpdbRegistration::with(['proven_pendaftaran', 'proven_bpms'])->where('nomor_pendaftaran', $nomorPendaftaran)->first();
            if (!$ppdbRegistration) return resultFunction("Err code PR-D: data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $nomorPendaftaran);

            return resultFunction("", true, $ppdbRegistration);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-D: catch " . $e->getMessage());
        }
    }

    public function searchRegistration($data) {
        try {
            $validator = \Validator::make($data, [
                "registration_number" => 'required',
                "date_of_birth" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-SR: " . collect($validator->errors()->all())->implode(" , "));

            $ppdbRegis = PpdbRegistration::with(['proven_pendaftaran', 'proven_bpms'])
                ->where('nomor_pendaftaran', $data['registration_number'])->where('tanggal_lahir', $data['date_of_birth'])
                ->first();
            if (!$ppdbRegis) return resultFunction("Err code PR-SR: data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $data['registration_number']);

            return resultFunction("", true, $ppdbRegis);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-SR: catch " . $e->getMessage());
        }
    }

    public function verify($data) {
        try {
            $validator = \Validator::make($data, [
                "id" => 'required',
                "type" => 'required'
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-D: " . collect($validator->errors()->all())->implode(" , "));

            $ppdbRegistration = PpdbRegistration::find($data['id']);
            if (!$ppdbRegistration) return resultFunction("Err code PR-D: data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $data['id']);

            if ($ppdbRegistration->status_pendaftaran !== 'menunggu verifikasi data')
                return resultFunction("Err code PR-D: proses tidak bisa dilanjutkan karena status sudah tidak menunggu verifikasi data");

            $ppdbRegistration->status_pendaftaran = $data['type'];

            if ($data['type'] === 'data terverifikasi') {
                $ppdbRegistration->status_pembayaran = 'menunggu pembayaran pendaftaran';
            }
            $ppdbRegistration->save();

            return resultFunction("Data pendaftaran berhasil diubah", true, $ppdbRegistration);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-D: catch " . $e->getMessage());
        }
    }

    public function uploadProven($type, $data) {
        try {
            $validator = \Validator::make($data, [
                "ppdb_registration_id" => 'required',
                "nama_rekening_tujuan" => 'required',
                "nomor_rekening_tujuan" => 'required',
                "nama_rekening_pengirim" => 'required',
                "nomor_rekening_pengirim" => 'required',
                "tanggal_bayar" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-UP: " . collect($validator->errors()->all())->implode(" , "));

            $ppdbRegistration = PpdbRegistration::find($data['ppdb_registration_id']);
            if (!$ppdbRegistration) return resultFunction("Err code PR-UP: data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $data['ppdb_registration_id']);

            $ppdbRegistration->status_pembayaran = $type === 'uang pangkal' ? 'menunggu verifikasi uang pangkal' : 'menunggu verifikasi bukti bayar';
            $ppdbRegistration->save();

            $data['status'] = $type === 'uang pangkal' ? 'menunggu verifikasi uang pangkal' : 'menunggu verifikasi bukti bayar';
            if ($type === 'uang pangkal') {
                PpdbBpmsProvenFile::create($data);
            } else {
                PpdbRegistrationProvenFile::create($data);
            }

            return resultFunction("Data berhasil diupload", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-UP: catch " . $e->getMessage());
        }
    }

    public function reuploadProven($regisId, $id, $type) {
        try {
            $ppdbRegistration = PpdbRegistration::find($regisId);
            if (!$ppdbRegistration) return resultFunction("Err code PR-D: data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $regisId);

            if ($type === 'uang pangkal') {
                $bpmsProven = PpdbBpmsProvenFile::find($id);
                if (!$bpmsProven) return resultFunction("Err code PR-D: data bukti bayar uang pangkal tidak ditemukan untuk nomor pendaftaran " . $id);

                $bpmsProven->delete();
            } else {
                $ppdbProven = PpdbRegistrationProvenFile::find($id);
                if (!$ppdbProven) return resultFunction("Err code PR-D: data bukti bayar tidak ditemukan untuk nomor pendaftaran " . $id);

                $ppdbProven->delete();
            }

            $ppdbRegistration->status_pembayaran = $type === 'uang pangkal' ? 'menunggu pembayaran uang pangkal' : 'menunggu pembayaran pendaftaran';
            $ppdbRegistration->save();

            return resultFunction("Bukti bayar berhasil dihapus", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-RP: catch " . $e->getMessage());
        }
    }

    public function verifyProven($type, $data) {
        try {
            $validator = \Validator::make($data, [
                "id" => 'required',
                "type" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-VP: " . collect($validator->errors()->all())->implode(" , "));

            if ($type === 'uang pangkal') {
                $bpmsProven = PpdbBpmsProvenFile::find($data['id']);
                if (!$bpmsProven) return resultFunction("Err code PR-VP: bukti uang pangkal tidak ditemukan untuk nomor pendaftaran " . $data['id']);
                $ppdbRegisId = $bpmsProven->ppdb_registration_id;
            } else {
                $ppdbProven = PpdbRegistrationProvenFile::find($data['id']);
                if (!$ppdbProven) return resultFunction("Err code PR-VP: bukti bayar tidak ditemukan untuk nomor pendaftaran " . $data['id']);
                $ppdbRegisId = $ppdbProven->ppdb_registration_id;
            }

            $ppdbRegistration = PpdbRegistration::find($ppdbRegisId);
            if (!$ppdbRegistration) return resultFunction("Err code PR-VP:data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $ppdbRegisId);

            if ($type === 'uang pangkal') {
                $bpmsProven->status = $data['type'];
                $bpmsProven->save();
            } else {
                $ppdbProven->status = $data['type'];
                $ppdbProven->save();
            }

            if ($data['type'] === 'bukti terverifikasi') {
                $ppdbRegistration->status_pembayaran = $data['type'];
                $ppdbRegistration->save();
            }

            return resultFunction("Verifikasi Bukti Bayar berhasil", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-VP: catch " . $e->getMessage());
        }
    }

    public function verifyInterview($data) {
        try {
            $validator = \Validator::make($data, [
                "id" => 'required',
                "type" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-VI: " . collect($validator->errors()->all())->implode(" , "));

            $ppdbRegistration = PpdbRegistration::find($data['id']);
            if (!$ppdbRegistration) return resultFunction("Err code PR-VI:data pendaftaran tidak ditemukan untuk nomor pendaftaran " . $data['id']);

            $ppdbRegistration->status_pendaftaran = $data['type'];
            if ($data['type'] === 'lolos wawancara') {
                $ppdbRegistration->status_pembayaran = 'menunggu pembayaran uang pangkal';
            }
            $ppdbRegistration->save();

            return resultFunction("Update status pendaftaran berhasil", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-VI: catch " . $e->getMessage());
        }
    }

    public function index($request, $all = false) {
        $filters = $request->only(['status_pendaftaran', 'status_pembayaran', 'jenjang', 'punya_nis']);

        $ppdbRegistrations = PpdbRegistration::with(['proven_pendaftaran', 'proven_bpms', 'student_ppdb_registration.student']);

        if (!empty($filters['status_pendaftaran'])) {
            $ppdbRegistrations = $ppdbRegistrations->where('status_pendaftaran', $filters['status_pendaftaran']);
        }

        if (!empty($filters['status_pembayaran'])) {
            $ppdbRegistrations = $ppdbRegistrations->where('status_pembayaran', $filters['status_pembayaran']);
        }

        if (!empty($filters['jenjang'])) {
            $ppdbRegistrations = $ppdbRegistrations->where('jenjang', $filters['jenjang']);
        }


        if (!empty($filters['punya_nis'])) {
            if ($filters['punya_nis'] == 'ya') {
                $ppdbRegistrations = $ppdbRegistrations->whereHas('student_ppdb_registration');
            } elseif ($filters['punya_nis'] == 'tidak') {
                $ppdbRegistrations = $ppdbRegistrations->whereDoesntHave('student_ppdb_registration');
            }
        }

        if (!$all) {
            $ppdbRegistrations = $ppdbRegistrations->orderBy('id', 'desc')->paginate(25);
        } else {
            $ppdbRegistrations = $ppdbRegistrations->get();
        }
        return $ppdbRegistrations;
    }

    public function importReceivedStudent($request) {
        try {
            $data = Excel::toArray(new PpdbRegistrationImport(), $request->file('file_excel'));

            $dataProcess = [];
            foreach ($data[0] as $key => $datum) {
                if ($key > 0) {
                    $dataProcess[] = $datum;
                }
            }

            return resultFunction("", true, $dataProcess);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-IRS: catch " . $e->getMessage());
        }
    }

    public function importData($data) {
        try {
            DB::beginTransaction();

            $ppdbRegistrations = PpdbRegistration::whereIn('id', array_column($data, 0))->get();

            foreach ($ppdbRegistrations as $ppdbRegistration) {
                $dataImportSelect = null;

                foreach ($data as $item) {
                    if ($item[0] === $ppdbRegistration->id) {
                        $dataImportSelect = $item;
                        break;
                    }
                }

                if ($dataImportSelect) {
                    $student = new Student();
                    $student->nomor_induk_siswa = $dataImportSelect[3];
                    $student->nama = $dataImportSelect[1];
                    $student->angkatan = '2023/2024';
                    $student->jenjang = $dataImportSelect[2];
                    $student->level = $dataImportSelect[2] === 'SMA' ? 'X' : ($dataImportSelect[2] === 'SMP' ? 'VII' : 'I');
                    $student->kelas = explode("-", $dataImportSelect[4])[1];
                    $student->nama_kelas = $dataImportSelect[4];
                    $student->jenis_kelamin = $ppdbRegistration->jenis_kelamin;
                    $student->tempat_lahir = $ppdbRegistration->tempat_lahir;
                    $student->tanggal_lahir = $ppdbRegistration->tanggal_lahir;
                    $student->save();

                    $studentPpdbRegistration = new StudentPpdbRegistration();
                    $studentPpdbRegistration->student_id = $student->id;
                    $studentPpdbRegistration->ppdb_registration_id = $ppdbRegistration->id;
                    $studentPpdbRegistration->save();

                    $studentUpgradeHistory = new StudentUpgradeHistory();
                    $studentUpgradeHistory->student_id = $student->id;
                    $studentUpgradeHistory->jenjang_selanjutnya = $student->jenjang;
                    $studentUpgradeHistory->level_selanjutnya = $student->level;
                    $studentUpgradeHistory->kelas_selanjutnya = $student->kelas;
                    $studentUpgradeHistory->tahun = '2023';
                    $studentUpgradeHistory->save();

                    $studentDetail = new StudentDetail();
                    $studentDetail->student_id = $student->id;
                    $studentDetail->kelurahan = $ppdbRegistration->kelurahan;
                    $studentDetail->kecamatan = $ppdbRegistration->kecamatan;
                    $studentDetail->kota_atau_kabupaten = $ppdbRegistration->kota_atau_kabupaten;
                    $studentDetail->provinsi = $ppdbRegistration->provinsi;
                    $studentDetail->kewarganegaraan = $ppdbRegistration->kewarganegaraan;
                    $studentDetail->transportasi_ke_sekolah = $ppdbRegistration->transportasi_ke_sekolah;
                    $studentDetail->jarak_ke_sekolah = $ppdbRegistration->jarak_ke_sekolah;
                    $studentDetail->waktu_tempuh_ke_sekolah = $ppdbRegistration->waktu_tempuh_ke_sekolah;
                    $studentDetail->berat_badan = $ppdbRegistration->berat_badan;
                    $studentDetail->save();

                    $userParent = new UserParent();
                    $userParent->student_id = $student->id;
                    $userParent->kata_sandi = Hash::make(date('Ymd', strtotime($ppdbRegistration->tanggal_lahir)));
                    $userParent->ayah = $ppdbRegistration->nama_ayah;
                    $userParent->ibu = $ppdbRegistration->nama_ibu;
                    $userParent->wali = $ppdbRegistration->nama_wali;
                    $userParent->telepon_ayah = $ppdbRegistration->telepon_ayah;
                    $userParent->telepon_ibu = $ppdbRegistration->telepon_ibu;
                    $userParent->telepon_wali = $ppdbRegistration->telepon_wali;
                    $userParent->save();
                }
            }

            DB::commit();
            return resultFunction("Sukses Import Data", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-ID: catch " . $e->getMessage());
        }
    }
}