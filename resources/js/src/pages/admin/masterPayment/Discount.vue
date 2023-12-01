<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master Pembayaran</span></li>
                    <li class="breadcrumb-item active"><span>Potongan Pembayaran</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Potongan Pembayaran</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Potongan Pembayaran</th>
                                <th>Persenan Potongan Pembayaran</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in paymentDiscounts" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nama_potongan_pembayaran }}</td>
                                <td>{{ ol.persenan_potongan_pembayaran }}</td>
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
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Nama Potongan Pembayaran <span class="text-danger"><b>*)</b></span></label>
                                <input type="text" v-model="formData.nama_potongan_pembayaran" class="form-control" placeholder="Anah Asuh">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Persenan Potongan Pembayaran (%) <span class="text-danger"><b>*)</b></span></label>
                                <input type="number" v-model="formData.persenan_potongan_pembayaran" class="form-control" placeholder="50 (50%)">
                            </div>
                        </div>
                        <button class="btn btn-primary mt-2">
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
                    title: ""
                },
                paymentDiscounts: [
                    {
                        "id": 0,
                        'nama_potongan_pembayaran': "Anak Asuh",
                        'persenan_potongan_pembayaran': 100
                    }
                ]
            }
        },
        methods: {
            handleShowDetail(ol = null) {
                this.formData = ol == null ?
                    {
                        "id": null,
                        'nama_potongan_pembayaran': "",
                        'persenan_potongan_pembayaran': ""
                    }: ol
                console.log("handle", this.formData)
                $("#addModal").modal("show")
            }
        }
    }
</script>