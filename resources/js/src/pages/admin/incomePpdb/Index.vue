<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Pemasukan PPDB</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Pemasukan PPDB
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-primary">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">Rp. {{ totalPendaftaran | formatPrice }}</div>
                                            <div>Total Uang Pendaftaran</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-warning">
                                    <div class="card-body d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">Rp. {{ totalUangPangkal | formatPrice }}</div>
                                            <div>Total Uang Pangkal</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Tahun Ajaran</label>
                                    <select v-model="formFilter.angkatan" class="form-control">
                                        <option value="2023/2024">2023/2024</option>
                                        <option value="2022/2023">2022/2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex align-items-bottom justify-content-end">
                                <button class="btn btn-success" type="button" @click="handleGetData()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nomor Pendaftaran</th>
                                        <th>Nama</th>
                                        <th>Status Pendaftaran</th>
                                        <th>Status Pembayaran</th>
                                        <th>Uang Pendaftaran</th>
                                        <th>Uang Pangkal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(pp, ppI) in ppdbRegistrations" :key="ppI">
                                            <td>{{ pp.nomor_pendaftaran }}</td>
                                            <td>{{ pp.nama_lengkap }}</td>
                                            <td>{{ pp.status_pendaftaran }}</td>
                                            <td>{{ pp.status_pembayaran }}</td>
                                            <td>{{ pp.proven_pendaftaran.jumlah_bayar | formatPrice }}</td>
                                            <td>
                                                <span v-if="pp.proven_bpms">{{ pp.proven_bpms.jumlah_bayar | formatPrice }}</span>
                                                <span v-else>0</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-end">
                                                <pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="handleGetData"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                ppdbRegistrations: [],
                totalPendaftaran: 0,
                totalUangPangkal: 0,
                page: 1,
                totalData: 0,
                perPage: 0,
                formFilter: {
                    angkatan: "2023/2024"
                }
            }
        },
        mounted() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    const filters = new URLSearchParams(this.formFilter).toString()
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/dashboard/income-ppdb?page=${this.page}&${filters}`)
                    console.log("resp", resp)
                    this.$vs.loading.close()
                    this.ppdbRegistrations = resp.data.data
                    this.totalPendaftaran = resp.total_pendaftaran
                    this.totalUangPangkal = resp.total_uang_pangkal
                    this.totalData = resp.data.total
                    this.page = resp.data.current_page
                    this.perPage = resp.data.per_page
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