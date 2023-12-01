<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master Pembayaran</span></li>
                    <li class="breadcrumb-item active"><span>Rekening Kas</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Rekening Kas</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Jenjang</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in paymentAccountBanks" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nama_bank }}</td>
                                <td>{{ ol.nomor_rekening }}</td>
                                <td>{{ ol.jenjang }}</td>
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
                        <h5 class="modal-title" id="staticBackdropLabel">{{ this.formData.id === null ? 'Tambah' : 'Ubah' }} Rekening Kas</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Nama Bank <span class="text-danger"><b>*)</b></span></label>
                                <input type="text" v-model="formData.nama_bank" class="form-control" placeholder="Contoh: BCA">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nomor Rekening <span class="text-danger"><b>*)</b></span></label>
                                <input type="text" v-model="formData.nomor_rekening" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Jenjang <span class="text-danger"><b>*)</b></span></label>
                                <select class="form-control" v-model="formData.jenjang">
                                    <option value="">--Pilih--</option>
                                    <option value="TK">TK</option>
                                    <option value="SD">SD</option>
                                </select>
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
                paymentAccountBanks: [
                    {
                        "id": 0,
                        'nama_bank': "BCA",
                        'nomor_rekening': "012312312",
                        "jenjang": "TK"
                    }
                ]
            }
        },
        methods: {
            handleShowDetail(ol = null) {
                this.formData = ol == null ?
                    {
                        "id": null,
                        'nama_bank': "",
                        'nomor_rekening': "",
                        "jenjang": ""
                    }: ol
                console.log("handle", this.formData)
                $("#addModal").modal("show")
            }
        }
    }
</script>