<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master Pembayaran</span></li>
                    <li class="breadcrumb-item active"><span>Tarif Pembayaran</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Tarif Pembayaran</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tarif Pembayaran</th>
                                <th>Pos Pembayaran</th>
                                <th>Tipe</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in paymentTariffs" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.tarif_pembayaran }}</td>
                                <td>{{ ol.pos_pembayaran }}</td>
                                <td>{{ ol.tipe }}</td>
                                <td>{{ ol.tahun_ajaran }}</td>
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ formData.id === null ? 'Tambah' : 'Ubah' }} Tipe Pembayaran</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label">Pos Pembayaran <span class="text-danger"><b>*)</b></span></label>
                                    <select class="form-control" v-model="formData.pos_pembayaran" required>
                                        <option value="">--Pilih--</option>
                                        <option value="Antar Jemput">Antar Jemput</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">Tarif Pembayaran <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" v-model="formData.tarif_pembayaran" class="form-control" placeholder="Contoh: TALENT ACTIVITY TAHFIZH TK">
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">Tipe <span class="text-danger"><b>*)</b></span></label>
                                    <select class="form-control" v-model="formData.tipe" required>
                                        <option value="">--Pilih--</option>
                                        <option value="Bulanan">Bulanan</option>
                                        <option value="Bebas">Bebas</option>
                                        <option value="PSB">PSB</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">Tahun Ajaran <span class="text-danger"><b>*)</b></span></label>
                                    <select class="form-control" v-model="formData.tahun_ajaran" required>
                                        <option value="">--Pilih--</option>
                                        <option value="2025/2026">2025/2026</option>
                                        <option value="2024/2025">2024/2025</option>
                                        <option value="2023/2022">2023/2022</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">Status <span class="text-danger"><b>*)</b></span></label>
                                    <select class="form-control" v-model="formData.status" required>
                                        <option value="">--Pilih--</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak aktif">Tidak Aktif</option>
                                    </select>
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
                    id: "",
                    jenis_pembayaran: "",
                    pos_pembayaran: "",
                    nominal: 0,
                    status: ''
                },
                paymentTariffs: [
                    {
                        "id": 0,
                        'pos_pembayaran': 'Antar Jemput',
                        'tarif_pembayaran': "Katering",
                        'tipe': "Bulanan",
                        'tahun_ajaran': "2023/2022",
                        'status': 'aktif'
                    },
                    {
                        "id": 1,
                        'pos_pembayaran': 'Antar Jemput',
                        'tarif_pembayaran': "Katering",
                        'tipe': "Bebas",
                        'tahun_ajaran': "2023/2022",
                        'status': 'tidak aktif'
                    }
                ]
            }
        },
        methods: {
            handleSubmit() {

            },
            handleShowDetail(ol = null) {
                this.formData = ol === null ?
                    {
                        "id": 1,
                        'pos_pembayaran': '',
                        'tarif_pembayaran': "",
                        'tipe': 0,
                        'tahun_ajaran': 0,
                        'status': ''
                    }
                    : ol
                $("#addModal").modal("show")
            }
        }
    }
</script>