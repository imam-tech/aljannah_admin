<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Informasi</th>
            <th class="text-center">Judul</th>
            <th class="text-center">Info</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="labelData !== 'Konfirmasi Informasi'">
            <td class="text-danger"><b>Status Pendaftaran</b></td>
            <td colspan="2">
                <span v-if="detailRegistrationData.status === 'pending'">Sedang Diverifikasi Data</span>
                <span v-else-if="detailRegistrationData.status === 'verified'">
                    Data Valid
                    <table>
                        <tr>
                            <td colspan="4" class="text-center">Silahkan Melakukan Pembayaran Pendaftaran Rp.500.000 ke Bank CIMB (1111111) an. Aljannah</td>
                        </tr>
                        <tr>
                            <td>Upload Bukti</td>
                            <td>: </td>
                            <td>
                                <input type="file" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center">
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-upload"></i>Upload
                                </button>
                            </td>
                        </tr>
                    </table>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        <tr>
            <td rowspan="4" class="align-middle">
                <i class="fas fa-clipboard"></i> Informasi Pendaftaran
            </td>
            <td>Jenis Pendaftaran</td>
            <td class="text-end">Baru</td>
        </tr>
        <tr>
            <td>Gelombang</td>
            <td class="text-end">1</td>
        </tr>
        <tr>
            <td>Jenjang</td>
            <td class="text-end">SMA</td>
        </tr>
        <tr>
            <td>Jalur Pendaftaran</td>
            <td class="text-end">Regular</td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        <tr>
            <td rowspan="6" class="align-middle">
                <i class="fas fa-user"></i> Informasi Pribadi
            </td>
            <td>Nama Lengkap</td>
            <td class="text-end">{{ detailRegistrationData.nama }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td class="text-end">3241312312412142</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td class="text-end">Laki-Laki</td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td class="text-end">Jakarta</td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td class="text-end">03-10-1991</td>
        </tr>
        <tr>
            <td>Berat Badan</td>
            <td class="text-end">56 kg</td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        <tr>
            <td rowspan="6" class="align-middle">
                <i class="fas fa-user-friends"></i> Informasi Orang Tua
            </td>
            <td>Nama Lengkap Ayah</td>
            <td class="text-end">Hartono</td>
        </tr>
        <tr>
            <td>Nama Lengkap Ibu</td>
            <td class="text-end">Sri</td>
        </tr>
        <tr>
            <td>Nama Lengkap Wali</td>
            <td class="text-end"> - </td>
        </tr>
        <tr>
            <td>No Telepon Ayah</td>
            <td class="text-end">081232232</td>
        </tr>
        <tr>
            <td>No Telepon Ibu</td>
            <td class="text-end">081232232</td>
        </tr>
        <tr>
            <td>Not Telepon Wali</td>
            <td class="text-end"> - </td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        <tr>
            <td rowspan="4" class="align-middle">
                <i class="fas fa-school"></i> Informasi Asal Sekolah
            </td>
            <td>Nama Asal Sekolah</td>
            <td class="text-end">SMP N 1 Maju</td>
        </tr>
        <tr>
            <td>Status Asal Sekolah</td>
            <td class="text-end">Negeri</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td class="text-end">Jl. Merdeka, Kecamatan</td>
        </tr>
        <tr>
            <td>Tahun Lulus</td>
            <td class="text-end">2022</td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        <tr>
            <td rowspan="9" class="align-middle">
                <i class="fas fa-house-user"></i> Informasi Tempat Tinggal
            </td>
            <td>Kelurahan</td>
            <td class="text-end">Segar</td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td class="text-end">Mampang</td>
        </tr>
        <tr>
            <td>Kota/Kabupaten</td>
            <td class="text-end">Kota Bogor</td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td class="text-end">Jawa Barat</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td class="text-end">Indonesia</td>
        </tr>
        <tr>
            <td>Jenis Tempat Tinggal</td>
            <td class="text-end">Rumah Kontrak</td>
        </tr>
        <tr>
            <td>Transportasi ke Sekolah</td>
            <td class="text-end">Sepeda Motor</td>
        </tr>
        <tr>
            <td>Jarak ke Sekolah</td>
            <td class="text-end">10 km</td>
        </tr>
        <tr>
            <td>Waktu Tempuh ke Sekolah</td>
            <td class="text-end">30 menit</td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "AdmissionMainInfo",
        props: ['labelData', 'detailRegistrationData']
    }
</script>