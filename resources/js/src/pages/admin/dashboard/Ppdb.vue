<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Dashboard PPDB</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Dashboard PPDB
                    </div>
                    <div v-if="dashboard" class="card-body">

                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-primary">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{ dashboard.all }}</div>
                                            <div>Calon Siswa yang Mendaftar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-warning">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{ dashboard.paid_pendaftaran }}</div>
                                            <div>Calon Siswa Membayar Biaya Pendaftaran</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-success">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{ dashboard.lolos_wawancara }}</div>
                                            <div>Calon Siswa yang Lolos Wawancara</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-info">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{ dashboard.paid_uang_pangkal }}</div>
                                            <div>Calon Siswa yang Membayar Uang Pangkal</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                dashboard: ""
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/dashboard/ppdb`)
                    this.$vs.loading.close()
                    this.dashboard = resp
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