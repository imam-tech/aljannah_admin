<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Pembayaran Siswa</span></li>
                    <li class="breadcrumb-item active"><span>Pembayaran Tagihan</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <span>Informasi</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Pilih Jenjang</label>
                                <select class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="TK">TK</option>
                                    <option value="SD">SD</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Pilih Kelas</label>
                                <select class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Pilih Siswa</label>
                                <select class="form-control">
                                    <option value="">--Pilih--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td>Nama</td>
                                        <td>: </td>
                                        <td>Budi Hartono</td>
                                    </tr>
                                    <tr>
                                        <td>Jenjang/Kelas Terkini</td>
                                        <td>: </td>
                                        <td>TK/A1</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <span>Daftar Tagihan Bulanan</span>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tagihan</th>
                                <th>Tahun Ajaran</th>
                                <th>Jenjang/Kelas Awal</th>
                                <th>Tagihan</th>
                                <th>Potongan</th>
                                <th>Tagihan Akhir</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in bills" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nama_tagihan }}</td>
                                <td>{{ ol.tahun_ajaran }}</td>
                                <td>{{ ol.jenjang }}</td>
                                <td>{{ ol.tagihan }}</td>
                                <td>{{ ol.potongan }}</td>
                                <td>{{ ol.tagihan_akhir }}</td>
                                <td>{{ ol.status }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary">
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
                bills: [
                    {
                        "id": 0,
                        'nama_tagihan': "Tagihan Juli",
                        "tahun_ajaran": "2023/2024",
                        "jenjang": "SMA-XI-IPA",
                        "tagihan": 200000,
                        "potongan": 0,
                        "tagihan_akhir": 200000,
                        "status": "Lunas"
                    },
                    {
                        "id": 1,
                        'nama_tagihan': "Tagihan Agustus",
                        "tahun_ajaran": "2023/2024",
                        "jenjang": "SMA-XI-IPA",
                        "tagihan": 200000,
                        "potongan": 0,
                        "tagihan_akhir": 200000,
                        "status": "Lunas"
                    }
                ]
            }
        },
        methods: {
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