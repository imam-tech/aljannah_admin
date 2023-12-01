<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Profil</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <span>Informasi Profil</span>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">Informasi</th>
                                <th class="text-center">Judul</th>
                                <th class="text-center">Info</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="3" class="align-middle">
                                    <i class="fas fa-clipboard"></i> Informasi Siswa
                                </td>
                                <td>NIS</td>
                                <td class="text-end">012312312312312</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td class="text-end">101231231231</td>
                            </tr>
                            <tr>
                                <td>Jenjang dan Kelas</td>
                                <td class="text-end">SMA XI</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="align-middle">
                                    <i class="fas fa-user"></i> Informasi Pribadi
                                </td>
                                <td>Nama Lengkap</td>
                                <td class="text-end">Budi Hartono</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                detailData: null,
                formData: {
                    title: ""
                },
                bills: [
                    {
                        "id": 0,
                        'nama_tagihan': "Tagihan Juli",
                        "tahun_ajaran": "2023/2024",
                        "jenjang": "SMA-XI-IPA",
                        "tagihan": 200000,
                        "potongan": 0,
                        "tagihan_akhir": 200000,
                        "status": "Lunas"
                    },
                    {
                        "id": 1,
                        'nama_tagihan': "Tagihan Agustus",
                        "tahun_ajaran": "2023/2024",
                        "jenjang": "SMA-XI-IPA",
                        "tagihan": 200000,
                        "potongan": 0,
                        "tagihan_akhir": 200000,
                        "status": "Lunas"
                    }
                ]
            }
        },
        methods: {
            handleShowDetail(ol = null) {
                this.formData = ol == null ?
                    {
                        "id": null,
                        'title': ""
                    }: ol
                console.log("handle", this.formData)
                $("#addModal").modal("show")
            }
        }
    }
</script>