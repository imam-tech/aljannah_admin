<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Daftar Pendaftaran Siswa Baru</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Filter</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Status Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                <select class="form-control" v-model="formFilter.status_pendaftaran" @change="handleChangeStatusPendaftaran()">
                                    <option value="">--Pilih--</option>
                                    <option :value="os" v-for="(os, osI) in optionStatusPendaftaran" :key="osI">{{ os }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Pembayaran</label>
                                <select class="form-control" v-model="formFilter.status_pembayaran">
                                    <option value="">--Semua Status--</option>
                                    <option :value="os" v-for="(os, osI) in optionStatusPembayaran" :key="osI">{{ os }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <button @click="handleGetData()" type="button" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
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
                                <th>Angkatan</th>
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
                                <td>{{ ol.nomor_pendaftaran }}</td>
                                <td>{{ ol.angkatan }}</td>
                                <td>{{ ol.nama_lengkap }}</td>
                                <td>{{ ol.jenis_kelamin }}</td>
                                <td>{{ ol.jenjang }}</td>
                                <td>{{ ol.created_at | formatDate }}</td>
                                <td>{{ ol.status_pendaftaran }}</td>
                                <td>
                                    <span v-if="['menunggu verifikasi bukti bayar', 'bukti terverifikasi', 'menunggu verifikasi uang pangkal'].includes(ol.status_pembayaran)">
                                        <button @click="handleShowPaymentConfirm(ol)" class="btn btn-warning">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </span>
                                    {{ ol.status_pembayaran }}
                                </td>
                                <td>
                                    <button type="button" @click="handleShowDetail(ol)" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button v-if="ol.status_pendaftaran === 'data terverifikasi' && ol.status_pembayaran === 'bukti terverifikasi'"
                                            @click="handleConfirmWawancara('lolos wawancara', ol.id)" type="button" class="btn btn-warning">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button v-if="ol.status_pendaftaran === 'data terverifikasi' && ol.status_pembayaran === 'bukti terverifikasi'"
                                            @click="handleConfirmWawancara('tidak lolos wawancara', ol.id)" type="button" class="btn btn-danger">
                                        <i class="fas fa-times-circle"></i>
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
                <div v-if="detailRegistrationData" class="modal-content">
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
                                <td>Status Pendaftaran</td>
                                <td colspan="2" class="text-end">{{ detailRegistrationData.status_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td colspan="2" class="text-end">{{ detailRegistrationData.status_pembayaran }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="row">
                                        <div v-if="detailRegistrationData.proven_pendaftaran" class="col-md-6">
                                            <table>
                                                <tr>
                                                    <td colspan="3" class="text-center">Detail Pembayaran pendaftaran</td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah yang dibayar</td>
                                                    <td>: </td>
                                                    <td>Rp. {{ detailRegistrationData.proven_pendaftaran.jumlah_bayar | formatPrice }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nomor_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nama_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nomor_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nama_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Transfer</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.tanggal_bayar}}</td>
                                                </tr>
                                                <tr>
                                                    <td>File Bukti Bayar</td>
                                                    <td>: </td>
                                                    <td><a :href="detailRegistrationData.proven_pendaftaran.file_bukti_bayar"><i class="fas fa-link"></i></a></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div v-if="detailRegistrationData.proven_bpms" class="col-md-6">
                                            <table>
                                                <tr>
                                                    <td colspan="3" class="text-center">Detail Pembayaran Uang Pangkal</td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah yang dibayar</td>
                                                    <td>: </td>
                                                    <td>Rp. {{ detailRegistrationData.proven_bpms.jumlah_bayar | formatPrice }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nomor_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nama_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nomor_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nama_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Transfer</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.tanggal_bayar}}</td>
                                                </tr>
                                                <tr>
                                                    <td>File Bukti Bayar</td>
                                                    <td>: </td>
                                                    <td><a :href="detailRegistrationData.proven_bpms.file_bukti_bayar"><i class="fas fa-link"></i></a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Pendaftaran</td>
                                <td colspan="2" class="text-end">{{ detailRegistrationData.nomor_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="4" class="align-middle">
                                    <i class="fas fa-clipboard"></i> Informasi Pendaftaran
                                </td>
                                <td>Jenis Pendaftaran</td>
                                <td class="text-end">{{ detailRegistrationData.jenis_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Gelombang</td>
                                <td class="text-end">{{ detailRegistrationData.gelombang_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Jenjang</td>
                                <td class="text-end">{{ detailRegistrationData.jenjang }}</td>
                            </tr>
                            <tr>
                                <td>Jalur Pendaftaran</td>
                                <td class="text-end">{{ detailRegistrationData.jalur_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="align-middle">
                                    <i class="fas fa-user"></i> Informasi Pribadi
                                </td>
                                <td>Nama Lengkap</td>
                                <td class="text-end">{{ detailRegistrationData.nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td class="text-end">{{ detailRegistrationData.nomor_induk_kependudukan }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td class="text-end">{{ detailRegistrationData.jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td class="text-end">{{ detailRegistrationData.tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td class="text-end">{{ detailRegistrationData.tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Berat Badan</td>
                                <td class="text-end">{{ detailRegistrationData.berat_badan }} kg</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="align-middle">
                                    <i class="fas fa-user-friends"></i> Informasi Orang Tua
                                </td>
                                <td>Nama Lengkap Ayah</td>
                                <td class="text-end">{{ detailRegistrationData.nama_ayah }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap Ibu</td>
                                <td class="text-end">{{ detailRegistrationData.nama_ibu }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap Wali</td>
                                <td class="text-end">{{ detailRegistrationData.nama_wali }}</td>
                            </tr>
                            <tr>
                                <td>No Telepon Ayah</td>
                                <td class="text-end">{{ detailRegistrationData.telepon_ayah }}</td>
                            </tr>
                            <tr>
                                <td>No Telepon Ibu</td>
                                <td class="text-end">{{ detailRegistrationData.telepon_ibu }}</td>
                            </tr>
                            <tr>
                                <td>Not Telepon Wali</td>
                                <td class="text-end">{{ detailRegistrationData.telepon_wali }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="4" class="align-middle">
                                    <i class="fas fa-school"></i> Informasi Asal Sekolah
                                </td>
                                <td>Nama Asal Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.nama_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td>Status Asal Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.status_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.alamat_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Lulus</td>
                                <td class="text-end">{{ detailRegistrationData.tahun_lulus_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="9" class="align-middle">
                                    <i class="fas fa-house-user"></i> Informasi Tempat Tinggal
                                </td>
                                <td>Kelurahan</td>
                                <td class="text-end">{{ detailRegistrationData.kelurahan }}</td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td class="text-end">{{ detailRegistrationData.kecamatan }}</td>
                            </tr>
                            <tr>
                                <td>Kota/Kabupaten</td>
                                <td class="text-end">{{ detailRegistrationData.kota_atau_kabupaten }}</td>
                            </tr>
                            <tr>
                                <td>Provinsi</td>
                                <td class="text-end">{{ detailRegistrationData.provinsi }}</td>
                            </tr>
                            <tr>
                                <td>Kewarganegaraan</td>
                                <td class="text-end">{{ detailRegistrationData.kewarganegaraan }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Tempat Tinggal</td>
                                <td class="text-end">{{ detailRegistrationData.jenis_tempat_tinggal }}</td>
                            </tr>
                            <tr>
                                <td>Transportasi ke Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.transportasi_ke_sekolah }}</td>
                            </tr>
                            <tr>
                                <td>Jarak ke Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.jarak_ke_sekolah }} km</td>
                            </tr>
                            <tr>
                                <td>Waktu Tempuh ke Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.waktu_tempuh_ke_sekolah }} menit</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="detailRegistrationData.status_pendaftaran === 'menunggu verifikasi data'" class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="handleConfirmData('data terverifikasi')">
                            <i class="fas fa-check-circle"></i> Ya, Data Benar
                        </button>
                        <button type="button" class="btn btn-danger" @click="handleConfirmData('data tidak valid')">
                            <i class="fas fa-times-circle"></i> Tolak, Data Salah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verificationPaymentModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div v-if="detailPaymentData" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? 'Informasi Bukti Bayar Uang Pangkal' : 'Informasi Bukti Bayar Pendaftaran' }}</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td>Nomor Pendaftaran</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.nomor_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.status : detailPaymentData.proven_pendaftaran.status }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Bayar</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.tanggal_bayar : detailPaymentData.proven_pendaftaran.tanggal_bayar }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Bayar</td>
                                <td>: </td>
                                <td>
                                    <span v-if="detailPaymentData.status_pendaftaran === 'lolos wawancara'">Rp. {{ detailPaymentData.proven_bpms.jumlah_bayar | formatPrice }}</span>
                                    <span v-else>Rp. {{ detailPaymentData.proven_pendaftaran.jumlah_bayar | formatPrice }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Bukti Bayar</td>
                                <td>: </td>
                                <td><a :href="detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.file_bukti_bayar : detailPaymentData.proven_pendaftaran.file_bukti_bayar" target="_blank"><button class="btn btn-info" type="button">
                                    <i class="fas fa-link"></i>
                                </button></a></td>
                            </tr>
                            <tr>
                                <td>Nama Rekening Tujuan</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nama_rekening_tujuan : detailPaymentData.proven_pendaftaran.nama_rekening_tujuan }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening Tujuan</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nomor_rekening_tujuan : detailPaymentData.proven_pendaftaran.nomor_rekening_tujuan }}</td>
                            </tr>
                            <tr>
                                <td>Nama Rekening Pengirim</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nama_rekening_pengirim : detailPaymentData.proven_pendaftaran.nama_rekening_pengirim }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening Pengirim</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nomor_rekening_pengirim : detailPaymentData.proven_pendaftaran.nomor_rekening_pengirim }}</td>
                            </tr>
                            <tr v-if="['menunggu verifikasi bukti bayar', 'menunggu verifikasi uang pangkal'].includes(detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.status : detailPaymentData.proven_pendaftaran.status)">
                                <td colspan="3" class="text-center">
                                    <button type="button" @click="handleConfirmProven('bukti terverifikasi')" class="btn btn-primary">
                                        <i class="fas fa-check-circle"></i>Konfirm</button>
                                    <button type="button" @click="handleConfirmProven('bukti tidak valid')" class="btn btn-danger"><i class="fas fa-times-circle"></i>Tolak</button>
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
                detailRegistrationData: null,
                detailPaymentData: null,
                onlineAdmissions: [],
                formFilter: {
                    status_pendaftaran: '',
                    status_pembayaran: ''
                },
                optionStatusPendaftaran: [
                    'menunggu verifikasi data', 'data terverifikasi', 'lolos wawancara'
                ],
                optionStatusPembayaran: []
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            handleChangeStatusPendaftaran() {
                if (['menunggu verifikasi data',''].includes(this.formFilter.status_pendaftaran)) {
                    this.optionStatusPembayaran = [];
                } else if (this.formFilter.status_pendaftaran === 'data terverifikasi') {
                    this.optionStatusPembayaran = ['menunggu pembayaran pendaftaran', 'menunggu verifikasi bukti bayar', 'bukti terverifikasi'];
                } else if (this.formFilter.status_pendaftaran === 'lolos wawancara') {
                    this.optionStatusPembayaran = ['menunggu pembayaran uang pangkal', 'menunggu verifikasi uang pangkal', 'bukti terverifikasi'];
                }
            },
            async handleGetData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/ppdb?status_pendaftaran=${this.formFilter.status_pendaftaran}&status_pembayaran=${this.formFilter.status_pembayaran}`)
                    this.onlineAdmissions = resp.data
                    this.$vs.loading.close()
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            },
            handleShowPaymentConfirm(ol) {
                this.detailPaymentData = ol
                $("#verificationPaymentModal").modal('show')
            },
            handleShowDetail(ol) {
                this.detailRegistrationData = ol
                $("#detailDataModal").modal("show")
            },
            handleConfirmData(type) {
                $("#detailDataModal").modal("hide")
                let title = "Apakah Anda yakin data calon siswa tidak valid?";
                if (type === 'data terverifikasi') {
                    title = "Apakah Anda yakin data calon siswa sudah valid? Notifikasi akan dikirim ke email atau no telepon untuk melakukan pembayaran pendaftaran.";
                }
                Swal.fire({
                    icon: 'info',
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        try {
                            this.$vs.loading();
                            const resp = await this.$axios.post(`api/ppdb/verify`, {
                                id: this.detailRegistrationData.id,
                                type: type
                            })
                            this.$vs.loading.close()
                            if (!resp.status) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: resp.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                this.handleGetData()
                            }
                        } catch (e) {
                            this.$vs.loading.close()
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: e.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
                    } else {
                        $("#detailDataModal").modal("show")
                    }
                })
            },
            handleConfirmProven(type) {
                $("#verificationPaymentModal").modal("hide")
                let title = "Apakah Anda yakin bukti bayar tidak valid?";
                if (type === 'bukti terverifikasi') {
                    title = "Apakah Anda yakin bukti bayar sudah valid?.";
                }
                Swal.fire({
                    icon: 'info',
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        try {
                            this.$vs.loading();
                            const resp = await this.$axios.post(`api/ppdb/${this.detailPaymentData.status_pendaftaran === 'lolos wawancara' ? 'uang pangkal' : 'pendaftaran'}/verify-proven`, {
                                id: this.detailPaymentData.status_pendaftaran === 'lolos wawancara' ? this.detailPaymentData.proven_bpms.id : this.detailPaymentData.proven_pendaftaran.id,
                                type: type
                            })
                            this.$vs.loading.close()
                            if (!resp.status) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: resp.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                this.handleGetData()
                            }
                        } catch (e) {
                            this.$vs.loading.close()
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: e.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
                    } else {
                        $("#verificationPaymentModal").modal("show")
                    }
                })
            },
            handleConfirmWawancara(type, id) {
                let title = "Apakah Anda yakin pendaftar ini tidak lolos tes wawancara?";
                if (type === 'lolos wawancara') {
                    title = "Apakah Anda yakin pendaftar ini lolos tes wawancara?";
                }
                Swal.fire({
                    icon: 'info',
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        try {
                            this.$vs.loading();
                            const resp = await this.$axios.post(`api/ppdb/verify-interview`, {
                                id: id,
                                type: type
                            })
                            this.$vs.loading.close()
                            if (!resp.status) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: resp.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                this.handleGetData()
                            }
                        } catch (e) {
                            this.$vs.loading.close()
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: e.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
                    }
                })
            }
        }
    }
</script>