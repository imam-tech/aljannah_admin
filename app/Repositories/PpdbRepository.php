<?php

namespace App\Repositories;

use App\Models\PpdbRegistration;

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

            $ppdbHistory = PpdbRegistration::where('nomor_pendaftaran', 'LIKE', '%' . $code . '-'.date("Y").'%')->count();
            $nomorPendaftaran = $code . '-' . date("Y") . "-" . ($ppdbHistory+1);
            $data['nomor_pendaftaran'] = $nomorPendaftaran;
            $data['status_pendaftaran'] = 'menunggu verifikasi data';
            $data['status_pembayaran'] = '-';
            PpdbRegistration::create($data);

            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-S: catch " . $e->getMessage());
        }
    }
}