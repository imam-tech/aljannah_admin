<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master User</span></li>
                    <li class="breadcrumb-item active"><span>Data User</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Data User</span>
                            <span><button @click="handleShowDetail()" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button></span>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No Handphone</th>
                                <th>Jabatan</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in users" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nik }}</td>
                                <td>{{ ol.nama }}</td>
                                <td>{{ ol.no_telepon }}</td>
                                <td>{{ ol.jabatan }}</td>
                                <td>{{ ol.kelas }}</td>
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
                        <h5 class="modal-title" id="staticBackdropLabel">{{ this.formData.id === null ? 'Tambah' : 'Ubah' }} Tipe Pembayaran</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Judul Jenis Pembayaran <span class="text-danger"><b>*)</b></span></label>
                                <input type="text" v-model="formData.title" class="form-control" placeholder="Contoh: Antar jemput">
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
                users: [
                    {
                        "id": 0,
                        'nik': "123123123",
                        "nama": 'budi',
                        'no_telepon': "0871232424",
                        "jabatan": "Guru",
                        "kelas": "6b",
                        "status": "aktif"
                    },
                    {
                        "id": 1,
                        'nik': "12312312332",
                        "nama": 'hartono',
                        'no_telepon': "08123123123",
                        "jabatan": "Staf",
                        "kelas": "",
                        "status": "aktif"
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