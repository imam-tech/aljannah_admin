<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Daftar Siswa</span></li>
                    <li class="breadcrumb-item active"><span>Detail Siswa</span></li>
                </ol>
            </nav>
        </div>
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-end">
                <router-link to="/app/admin/student">
                    <button class="btn btn-success">
                        <i class="fas fa-backward"></i> Kembali
                    </button>
                </router-link>
            </div>
        </div>
        <div v-if="student" class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Informasi Siswa
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama</td>
                                <td>: </td>
                                <td>{{ student.nama }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>: </td>
                                <td>{{ student.jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Angkatan</td>
                                <td>: </td>
                                <td>{{ student.angkatan }}</td>
                            </tr>
                            <tr>
                                <td>Jenjang</td>
                                <td>: </td>
                                <td>{{ student.jenjang }}</td>
                            </tr>
                            <tr>
                                <td>Nama Kelas</td>
                                <td>: </td>
                                <td>{{ student.nama_kelas }}</td>
                            </tr>
                            <tr>
                                <td>Tempat, Tanggal Lahir</td>
                                <td>: </td>
                                <td>{{ student.tempat_lahir }}, {{ student.tanggal_lahir }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Informasi Lainnya
                    </div>
                    <div class="card-body">
                        <table v-if="student.student_details" class="table table-bordered">
                            <tr>
                                <td>Alamat Siswa</td>
                                <td>: </td>
                                <td>{{ student.student_details.kelurahan }}, {{ student.student_details.kecamatan }}, {{ student.student_details.kota_atau_kabupaten }}, {{ student.student_details.provinsi }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Tempat Tinggal</td>
                                <td>: </td>
                                <td>{{ student.student_details.jenis_tempat_tinggal }}</td>
                            </tr>
                            <tr>
                                <td>Transportasi ke Sekolah</td>
                                <td>: </td>
                                <td>{{ student.student_details.transportasi_ke_sekolah }}</td>
                            </tr>
                            <tr>
                                <td>Jarak ke Sekolah</td>
                                <td>: </td>
                                <td>{{ student.student_details.jarak_ke_sekolah }}</td>
                            </tr>
                            <tr>
                                <td>Waktu Tempuh ke Sekolah</td>
                                <td>: </td>
                                <td>{{ student.student_details.waktu_tempuh_ke_sekolah }}</td>
                            </tr>
                            <tr>
                                <td>Berat Badan</td>
                                <td>: </td>
                                <td>{{ student.student_details.berart_badan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Informasi Orang Tua
                    </div>
                    <div class="card-body">
                        <table v-if="student.user_parent" class="table table-bordered">
                            <tr>
                                <td>Nama Ayah</td>
                                <td>: </td>
                                <td>{{ student.user_parent.ayah }}</td>
                            </tr>
                            <tr>
                                <td>Nama Ibu</td>
                                <td>: </td>
                                <td>{{ student.user_parent.ibu }}</td>
                            </tr>
                            <tr>
                                <td>Nama Wali</td>
                                <td>: </td>
                                <td>{{ student.user_parent.wali }}</td>
                            </tr>
                            <tr>
                                <td>Telepon Ayah</td>
                                <td>: </td>
                                <td>{{ student.user_parent.telepon_ayah }}</td>
                            </tr>
                            <tr>
                                <td>Telepon Wali</td>
                                <td>: </td>
                                <td>{{ student.user_parent.telepon_wali }}</td>
                            </tr>
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
                student: ""
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/student/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return
                    }
                    this.student = resp.data
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