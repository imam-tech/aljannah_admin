<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Admin</span></li>
                    <li class="breadcrumb-item active"><span>Jabatan</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Jabatan</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in users" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nama }}</td>
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ this.formData.id === null ? 'Tambah' : 'Ubah' }} Jabatan</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Title <span class="text-danger"><b>*)</b></span></label>
                                <input type="text" v-model="formData.nama" class="form-control" placeholder="Contoh: Admin Keuangan">
                            </div>
                        </div>
                        <button type="button" @click="handleSave()" class="btn btn-primary mt-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
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
                    nama: ""
                },
                users: []
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/jabatan`)
                    this.$vs.loading.close()
                    this.users = resp
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
            handleShowDetail(ol = null) {
                if (!ol) {
                   this.formData = {
                       id: "",
                       nama: ""
                   }
                } else {
                    this.formData = ol
                }
                $("#addModal").modal("show")
            },
            async handleSave() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.post(`api/jabatan`, this.formData)
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
        }
    }
</script>