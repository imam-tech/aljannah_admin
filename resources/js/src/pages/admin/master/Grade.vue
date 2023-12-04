<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Master</span></li>
                    <li class="breadcrumb-item active"><span>Jenjang</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Jenjang
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jenjang</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in grades" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.nama }}</td>
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
                grades: []
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/general/jenjang`)
                    this.$vs.loading.close()
                    this.grades = resp
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