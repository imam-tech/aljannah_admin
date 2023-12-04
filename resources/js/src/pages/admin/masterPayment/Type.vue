<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master Pembayaran</span></li>
                    <li class="breadcrumb-item active"><span>Jenis Pembayaran</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Jenis Pembayaran</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis Pembayaran</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in paymentTypes" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.title }}</td>
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
                        <h5 class="modal-title" id="staticBackdropLabel">{{ this.formData.id === null ? 'Tambah' : 'Ubah' }} Tipe Pembayaran</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Judul Jenis Pembayaran <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" v-model="formData.title" class="form-control" placeholder="Contoh: Antar jemput" required>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">
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
                    title: ""
                },
                paymentTypes: [
                    {
                        "id": 0,
                        'title': "Antar jemput"
                    },
                    {
                        "id": 1,
                        'title': "SPP"
                    }
                ]
            }
        },
        methods: {
            handleSubmit() {
                return
            },
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