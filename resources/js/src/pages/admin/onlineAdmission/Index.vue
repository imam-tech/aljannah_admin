<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Daftar Siswa Baru</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Daftar Pendaftaran Siswa Baru</div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No Pendaftar</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Jenjang</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Pembayaran Pendaftaran</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in onlineAdmissions" :key="olI">
                                <td>{{ ol.nomor }}</td>
                                <td>{{ ol.nama }}</td>
                                <td>{{ ol.jenis }}</td>
                                <td>{{ ol.jenjang }}</td>
                                <td>{{ ol.tanggal_daftar }}</td>
                                <td>
                                    {{ ol.status === 'pending' ? 'Data Belum Diverifikasi' : "Data Valid" }}
                                </td>
                                <td>
                                    <span v-if="ol.pembayaran_pendaftaran === 'process'">
                                        Verifikasi Bukti Bayar
                                        <button @click="handleShowPaymentConfirm(ol)" class="btn btn-warning">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </span>
                                    <span v-else-if="ol.pembayaran_pendaftaran === 'paid'">Lunas</span>
                                </td>
                                <td>
                                    <button type="button" @click="handleShowDetail(ol)" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <div class="modal fade" id="detailDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div v-if="detailData" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informasi Pendaftar</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td colspan="2" class="text-end">{{ detailData.status === 'pending' ? 'Data Belum Diverifikasi' : "Data Valid" }}</td>
                            </tr>
                            <tr>
                                <td>Pembayaran Pendaftaran</td>
                                <td colspan="2" class="text-end">
                                    <span v-if="detailData.pembayaran_pendaftaran === 'process'">
                                        Verifikasi Bukti Bayar
                                    </span>
                                    <span v-else-if="detailData.pembayaran_pendaftaran === 'paid'">Lunas</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Pendaftaran</td>
                                <td colspan="2" class="text-end">{{ detailData.nomor }}</td>
                            </tr>
                            <tr>
                                <td rowspan="4" class="align-middle">
                                    <i class="fas fa-clipboard"></i> Informasi Pendaftaran
                                </td>
                                <td>Jenis Pendaftaran</td>
                                <td class="text-end">{{ detailData.jenis.toUpperCase() }}</td>
                            </tr>
                            <tr>
                                <td>Gelombang</td>
                                <td class="text-end">Gelombang {{ detailData.gelombang }}</td>
                            </tr>
                            <tr>
                                <td>Jenjang</td>
                                <td class="text-end">{{ detailData.jenjang.toUpperCase() }}</td>
                            </tr>
                            <tr>
                                <td>Jalur Pendaftaran</td>
                                <td class="text-end">{{ detailData.jalur }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="align-middle">
                                    <i class="fas fa-user"></i> Informasi Pribadi
                                </td>
                                <td>Nama Lengkap</td>
                                <td class="text-end">{{ detailData.nama }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td class="text-end">{{ detailData.nik }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td class="text-end">{{ detailData.jenis_kelamin.toLocaleUpperCase() }}</td>
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
                            </tbody>
                        </table>
                    </div>
                    <div v-if="detailData.status == 'pending'" class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="handleConfirmData('approve')">
                            <i class="fas fa-check-circle"></i> Ya, Data Benar
                        </button>
                        <button type="button" class="btn btn-danger" @click="handleConfirmData('reject')">
                            <i class="fas fa-times-circle"></i> Tolak, Data Salah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verificationPaymentModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informasi Pendaftar</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div v-if="detailPaymentData" class="modal-body">
                        <table>
                            <tr>
                                <td>Tanggal Bayar</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.bukti_bayar.tanggal_bayar }}</td>
                            </tr>
                            <tr>
                                <td>Bukti Bayar</td>
                                <td>: </td>
                                <td><a :href="detailPaymentData.bukti_bayar.link" target="_blank"><button class="btn btn-info" type="button">
                                    <i class="fas fa-link"></i>
                                </button></a></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-center">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-check-circle"></i>Konfirm</button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i>Tolak</button>
                                </td>
                            </tr>
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
                detailPaymentData: null,
                onlineAdmissions: [
                    {
                        "nomor": "A0001",
                        "nama": "Budi Hartono",
                        "nik": "321341231231231",
                        "jenis_kelamin": "laki-laki",
                        "tempat_lahir": "Jakarta",
                        "tanggal_lahir": "01-01-1991",
                        "berart_badan": "56",
                        "gelombang": "1",
                        "jenis": "Baru",
                        "jenjang": "SMA",
                        "tanggal_daftar": "01-01-2023",
                        "status" : 'pending',
                        "pembayaran_pendaftaran": "",
                        "nama_ayah": "Hartono",
                        "nama_ibu": "Sri",
                        "nama_wali": "",
                        "no_telepon_ayah": "0812313231",
                        "no_telepon_ibu": "08123123123",
                        "no_telepon_wali": "",
                        "nama_asal_sekolah": "SMPN 1 Maju",
                        "alamat_asal_sekolah": "Jl.Merdeka, Kecamatan",
                        "tahun_lulus": "2022",
                        "kelurahan": "Segar",
                        "kecamatan": "Mampang",
                        "Kota_kabupaten": "Kota Bogor",
                        "provinsi": "Jawa Barat",
                        "kewarganegaraan": "Indonesia",
                        "jenis_tempat_tinggal": "Rumah Kontrak",
                        "transportasi": "Sepeda motor",
                        "jarak": 10,
                        "waktu": 30
                    },
                    {
                        "nomor": "A0002",
                        "nama": "Satya Kaju",
                        "nik": "35123123123",
                        "jenis_kelamin": "perempuan",
                        "tempat_lahir": "Bandung",
                        "tanggal_lahir": "10-01-1992",
                        "berart_badan": "45",
                        "gelombang": "1",
                        "jenis": "Baru",
                        "jenjang": "SMP",
                        "tanggal_daftar": "01-01-2023",
                        "status" : 'verified',
                        "bukti_bayar": {
                            'tanggal_bayar': '02-01-2023',
                            'link': "www.google.com"
                        },
                        "pembayaran_pendaftaran": "process",
                        "nama_ayah": "Hartono",
                        "nama_ibu": "Sri",
                        "nama_wali": "",
                        "no_telepon_ayah": "0812313231",
                        "no_telepon_ibu": "08123123123",
                        "no_telepon_wali": "",
                        "nama_asal_sekolah": "SMPN 1 Maju",
                        "alamat_asal_sekolah": "Jl.Merdeka, Kecamatan",
                        "tahun_lulus": "2022",
                        "kelurahan": "Segar",
                        "kecamatan": "Mampang",
                        "Kota_kabupaten": "Kota Bogor",
                        "provinsi": "Jawa Barat",
                        "kewarganegaraan": "Indonesia",
                        "jenis_tempat_tinggal": "Rumah Kontrak",
                        "transportasi": "Sepeda motor",
                        "jarak": 10,
                        "waktu": 30
                    }
                ]
            }
        },
        methods: {
            handleShowPaymentConfirm(ol) {
                this.detailPaymentData = ol
                $("#verificationPaymentModal").modal('show')
            },
            handleShowDetail(ol) {
                this.detailData = ol
                $("#detailDataModal").modal("show")
            },
            handleConfirmData(type) {
                $("#detailDataModal").modal("hide")
                let iconLabel = "Konfirmasi"
                let title = "Apakah Anda yakin data calon siswa tidak valid?";
                if (type === 'approve') {
                    iconLabel = "Konfirmasi Data Valid"
                    title = "Apakah Anda yakin data calon siswa sudah valid? Notifikasi ke email atau no telepon siswa untuk melakukan pembayaran pendaftaran.";
                }
                Swal.fire({
                    icon: iconLabel,
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed == true) {

                    } else {
                        $("#detailDataModal").modal("show")
                    }
                })
            }
        }
    }
</script>