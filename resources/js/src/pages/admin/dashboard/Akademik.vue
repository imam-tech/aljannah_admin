<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Dashboard Akademik</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Informasi Siswa
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-primary">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">26K</div>
                                            <div>Siswa</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-warning">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">26K</div>
                                            <div>Guru</div>
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
                student: ""
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                // try {
                //     this.$vs.loading();
                //     const resp = await this.$axios.get(`api/student/${this.$route.params.id}/detail`)
                //     this.$vs.loading.close()
                //     if (!resp.status)  {
                //         Swal.fire({
                //             position: 'top',
                //             icon: 'error',
                //             title: resp.message,
                //             showConfirmButton: false,
                //             timer: 3000
                //         })
                //         return
                //     }
                //     this.student = resp.data
                // } catch (e) {
                //     this.$vs.loading.close()
                //     Swal.fire({
                //         position: 'top',
                //         icon: 'error',
                //         title: e.message,
                //         showConfirmButton: false,
                //         timer: 3000
                //     })
                // }
            },
        }
    }
</script>