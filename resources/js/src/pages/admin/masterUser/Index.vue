<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master User</span></li>
                    <li class="breadcrumb-item active"><span>Data Guru atau Staff</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Data Guru atau Staff</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Nomor Induk Kependudukan</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
                                <th>Jabatan</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in users" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nama_lengkap }}</td>
                                <td>{{ ol.nomor_induk_kependudukan }}</td>
                                <td>{{ ol.email }}</td>
                                <td>{{ ol.telepon }}</td>
                                <td>{{ ol.jenis_kelamin }}</td>
                                <td>{{ ol.jabatan.nama }}</td>
                                <td>
                                    <button type="button" @click="handleShowDetail(ol)" class="btn btn-warning">
                                        <i class="fas fa-pen-alt"></i>
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
        <div class="modal fade" id="addModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ this.formData.id === "" ? 'Tambah' : 'Ubah' }} Guru atau Staff</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  @submit.prevent="handleSubmit()">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" v-model="formData.nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Induk Kependudukan <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" v-model="formData.nomor_induk_kependudukan" class="form-control" placeholder="Nomor Induk Kependudukan" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger"><b>*)</b></span></label>
                                    <input type="email" v-model="formData.email" class="form-control" placeholder="Format ***x@****.***" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telepon <span class="text-danger"><b>*)</b></span></label>
                                    <input type="tel" v-model="formData.telepon" class="form-control" placeholder="Contoh: +62817******" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger"><b>*)</b></span></label>
                                    <select v-model="formData.jenis_kelamin" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jabatan <span class="text-danger"><b>*)</b></span></label>
                                    <select v-model="formData.jabatan_id" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option :value="j.id" v-for="(j, jI) in jabatan" :key="jI">{{ j.nama }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" v-model="formData.tempat_lahir" class="form-control" placeholder="Tempat Lahir Anda" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger"><b>*)</b></span></label>
                                    <input type="date" v-model="formData.tanggal_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelurahan <span class="text-danger"><b>*)</b></span></label>
                                    <input v-model="formData.kelurahan" type="text" class="form-control" placeholder="Contoh: Kelurahan Mampang" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kecamatan/Kota/Kabupaten <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" @keyup="handleSearchSubdistrict()" v-model="keywordAddress" class="form-control" placeholder="Silahkan cari kecamatan, kabupaten atau kota Anda" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pilih Alamat <span class="text-danger"><b>*)</b></span></label>
                                    <select @change="handleChooseAddress()" v-model="chooseAddress" class="form-control" required>
                                        <option :value="ao" v-for="(ao, aoI) in addressOptions" :key="aoI">{{ ao }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kewarganegaraan <span class="text-danger"><b>*)</b></span></label>
                                    <input v-model="formData.kewarganegaraan" type="text" class="form-control" value="Indonesia" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agama <span class="text-danger"><b>*)</b></span></label>
                                    <input v-model="formData.agama" type="text" class="form-control" value="Contoh: Islam" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger"><b>*)</b></span></label>
                                    <input v-model="formData.alamat" type="text" class="form-control" value="Contoh: RT/RW" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </form>
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
                    id: "",
                    nama_lengkap: "",
                    nomor_induk_kependudukan: "",
                    email: '',
                    telepon: '',
                    jenis_kelamin: '',
                    jabatan_id: '',
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    kelurahan: '',
                    kecamatan: '',
                    kota_atau_kabupaten: '',
                    alamat:'',
                    agama: '',
                    kewarganegaraan: '',
                },
                users: [],
                addressOptions: [],
                keywordAddress: "",
                chooseAddress: "",
                jabatan: []
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            handleShowDetail(ol = null) {
                if (ol === null) {

                    this.formData = {
                        id: "",
                        nama_lengkap: "",
                        nomor_induk_kependudukan: "",
                        email: '',
                        telepon: '',
                        jenis_kelamin: '',
                        jabatan_id: '',
                        tempat_lahir: '',
                        tanggal_lahir: '',
                        kelurahan: '',
                        kecamatan: '',
                        kota_atau_kabupaten: '',
                        alamat: '',
                        agama: '',
                        kewarganegaraan: ''
                    }
                } else {
                    this.formData = ol
                    this.keywordAddress = ol.kecamatan
                    this.addressOptions = [ol.kecamatan + ', ' +  ol.kota_atau_kabupaten];
                    this.chooseAddress = ol.kecamatan + ', ' +  ol.kota_atau_kabupaten
                }
                $("#addModal").modal("show")
            },

            async handleSearchSubdistrict() {
                try {
                    if (this.keywordAddress.length < 3) {
                        return
                    }
                    this.addressOptions = await this.$axios.get(`api/general/address/search-subdistrict?keyword=${this.keywordAddress}`)
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

            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/teacher`, this.formData)
                    this.$vs.loading.close()
                    if (!resp.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return
                    }
                    $("#addModal").modal("hide")
                    this.handleGetData()
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

            async handleGetData() {
                try {
                    this.$vs.loading()
                    const users = await this.$axios.get(`api/teacher`)
                    this.users = users.data
                    this.jabatan = await this.$axios.get(`api/jabatan`)
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

            handleChooseAddress() {
                const arr = this.chooseAddress.split(", ")
                this.formData.kecamatan = arr[0]
                this.formData.kota_atau_kabupaten = arr[1]
            }
        }
    }
</script>