<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Daftar Siswa yang Diterima</span></li>
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
                                <label class="form-label">Jenjang <span class="text-danger"><b>*)</b></span></label>
                                <select class="form-control" v-model="formFilter.jenjang" @change="handleChangeStatusPendaftaran()">
                                    <option value="">--Pilih--</option>
                                    <option :value="os" v-for="(os, osI) in jenjangData" :key="osI">{{ os }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sudah Punya NIS <span class="text-danger"><b>*)</b></span></label>
                                <select class="form-control" v-model="formFilter.punya_nis" @change="handleChangeStatusPendaftaran()">
                                    <option value="ya">Punya</option>
                                    <option value="tidak">Tidak Punya</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-bottom justify-content-end">
                                <button @click="handleGetData()" type="button" class="btn btn-success">
                                    <i class="fas fa-search"></i> Cari
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
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span>Daftar Siswa yang Diterima</span>
                        <div>
                            <button type="button" @click="handleExportData()" class="btn btn-primary">
                                <i class="fas fa-file-export"></i>Export Data
                            </button>
                            <button type="button" @click="handleShowPopupImport()" class="btn btn-warning">
                                <i class="fas fa-file-import"></i>Import Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No Pendaftar</th>
                                <th v-if="formFilter.punya_nis == 'ya'">Nomor Induk Siswa</th>
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
                                <td v-if="formFilter.punya_nis == 'ya'">{{ ol.student_ppdb_registration.student.nomor_induk_siswa }}</td>
                                <td>{{ ol.nama_lengkap }}</td>
                                <td>{{ ol.jenis_kelamin }}</td>
                                <td>{{ ol.jenjang }}</td>
                                <td>{{ ol.created_at | formatDate }}</td>
                                <td>{{ ol.status_pendaftaran }}</td>
                                <td>
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
                            <tr>
                                <td colspan="9" class="text-end">
                                    <pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="handleGetData"/>
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
                </div>
            </div>
        </div>
        <div class="modal fade" id="importDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  @submit.prevent="handleImportData">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label">File Import <span class="text-danger"><b>*)</b></span></label>
                                    <input @change="handleInputFile()" ref="file" type="file" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmImportDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Import Data</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenjang</th>
                                    <th>Nomor Induk Siswa</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(id, idI) in importData" :key="idI">
                                    <td>{{ id[0] }}</td>
                                    <td>{{ id[1] }}</td>
                                    <td>{{ id[2] }}</td>
                                    <td>{{ id[3] }}</td>
                                    <td>{{ id[4] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <button @click="handleSubmitImportData()" type="button" class="btn btn-primary">
                                            Proses
                                        </button>
                                    </td>
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
                detailRegistrationData: null,
                onlineAdmissions: [],
                formFilter: {
                    status_pendaftaran: 'lolos wawancara',
                    status_pembayaran: 'bukti terverifikasi',
                    jenjang: '',
                    punya_nis: 'tidak'
                },
                jenjangData: [],
                file_import: '',
                importData: [],
                page: 1,
                totalData: 0,
                perPage: 0,
            }
        },
        mounted() {
            this.handleGetData()
            this.handleJenjang()
        },
        methods: {
            async handleImportData() {
                try {
                    this.$vs.loading()
                    let formDataCoa = new FormData();
                    const config = { headers: {'content-type' : 'multipart/form-data'}}
                    formDataCoa.append('file_excel', this.file_import);
                    const resp = await this.$axios.post(`api/ppdb/import-received-student`, formDataCoa, config)
                    this.$vs.loading.close()
                    if (!resp['status']) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return
                    }
                    $('#importDataModal').modal("hide")
                    this.importData = resp.data
                    $('#confirmImportDataModal').modal("show")
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

            handleInputFile() {
                this.file_import = this.$refs.file.files[0];
            },

            handleShowDetail(ol) {
                this.detailRegistrationData = ol
                $("#detailDataModal").modal("show")
            },

            async handleGetData() {
                try {
                    const filters = new URLSearchParams(this.formFilter).toString()
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/ppdb?page=${this.page}&${filters}`)
                    this.onlineAdmissions = resp.data
                    this.totalData = resp.total
                    this.page = resp.current_page
                    this.perPage = resp.per_page
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

            async handleJenjang() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/ppdb/jenjang-data`)
                    this.$vs.loading.close()
                    this.jenjangData = resp.jenjang;
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

            handleExportData() {
                window.open(`../../../export/received-student?status_pendaftaran=${this.formFilter.status_pendaftaran}&status_pembayaran=${this.formFilter.status_pembayaran}&jenjang=${this.formFilter.jenjang}&punya_nis=${this.formFilter.punya_nis}`, '_blank');
            },

            handleShowPopupImport() {
                $("#importDataModal").modal("show")
            },

            async handleSubmitImportData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.post(`api/ppdb/import-data`, this.importData)
                    this.handleGetData()
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
            }
        }
    }
</script>