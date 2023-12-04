<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master User</span></li>
                    <li class="breadcrumb-item active"><span>Wali Kelas</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Wali Kelas</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>Nama Wali</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in users" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.tahun_ajaran }}</td>
                                <td>{{ ol.teacher.nama_lengkap }}</td>
                                <td>{{ ol.kelas.nama_kelas }}</td>
                                <td>{{ ol.status }}</td>
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
                        <form @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Ajaran <span class="text-danger"><b>*)</b></span></label>
                                    <select v-model="formData.tahun_ajaran" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="2023/2024">2023/2024</option>
                                        <option value="2022/2023">2022/2023</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelas <span class="text-danger"><b>*)</b></span></label>
                                    <select v-model="formData.kelas_id" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option :value="j.id" v-for="(j, jI) in kelas" :key="jI" :disabled="j.wali_kelas ? (j.wali_kelas.status == 'aktif' ? true : false) : false">
                                            {{ j.nama_kelas }} {{ j.wali_kelas ? (j.wali_kelas.status === 'aktif' ? ' - ' + j.wali_kelas.teacher.nama_lengkap : '') : '' }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Guru <span class="text-danger"><b>*)</b></span></label>
                                    <select v-model="formData.teacher_id" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option :value="j.id" v-for="(j, jI) in teachers" :key="jI">{{ j.nama_lengkap }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger"><b>*)</b></span></label>
                                    <select v-model="formData.status" class="form-control" required>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak aktif">Tidak Aktif</option>
                                    </select>
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
                    teacher_id: "",
                    kelas_id: "",
                    tahun_ajaran: '',
                    status: 'aktif'
                },
                users: [],
                teachers: [],
                kelas: []
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
                        teacher_id: "",
                        kelas_id: "",
                        tahun_ajaran: '',
                        status: 'aktif'
                    }
                } else {
                    this.formData = ol
                }
                $("#addModal").modal("show")
            },

            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/teacher/wali-kelas`, this.formData)
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
                    const users = await this.$axios.get(`api/teacher/wali-kelas`)
                    this.users = users.data
                    this.kelas = await this.$axios.get(`api/general/kelas`)
                    this.teachers = (await this.$axios.get(`api/teacher`)).data
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
        }
    }
</script>