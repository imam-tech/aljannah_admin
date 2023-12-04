<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Daftar Siswa</span></li>
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
                                <label class="form-label">Angkatan <span class="text-danger"><b>*)</b></span></label>
                                <select class="form-control" v-model="formFilter.angkatan">
                                    <option value="">--Pilih--</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <button @click="handleGetData()" type="button" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
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
                    <div class="card-header d-flex justify-content-between">
                        Daftar Siswa
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nomor Induk Siswa</th>
                                <th>Nomor Induk Siswa Nasional</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Jenjang</th>
                                <th>Nama Kelas</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in students" :key="olI">
                                <td>{{ ol.nomor_induk_siswa }}</td>
                                <td>{{ ol.nomor_induk_siswa_nasional }}</td>
                                <td>{{ ol.nama }}</td>
                                <td>{{ ol.angkatan }}</td>
                                <td>{{ ol.jenjang }}</td>
                                <td>{{ ol.nama_kelas }}</td>
                                <td>
                                    <router-link :to="'student/' + ol.id + '/detail'">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </router-link>
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
                students: [],
                formFilter: {
                    angkatan: '2023/2024',
                }
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/student?agkatan=${this.formFilter.angkatan}`)
                    this.students = resp.data
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