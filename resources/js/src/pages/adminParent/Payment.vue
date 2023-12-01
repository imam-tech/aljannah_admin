<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Keuangan</span></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <span>Detail</span>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">Informasi</th>
                                <th class="text-center">Judul</th>
                                <th class="text-center">Info</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="3" class="align-middle">
                                    <i class="fas fa-clipboard"></i> Informasi Siswa
                                </td>
                                <td>NIS</td>
                                <td class="text-end">012312312312312</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td class="text-end">101231231231</td>
                            </tr>
                            <tr>
                                <td>Jenjang dan Kelas</td>
                                <td class="text-end">SMA XI</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td rowspan="3" class="align-middle">
                                    <i class="fas fa-user"></i> Informasi Pribadi
                                </td>
                                <td>Nama Lengkap</td>
                                <td class="text-end">Budi Hartono</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td class="text-end">3241312312412142</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td class="text-end">Laki-Laki</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <span>Riwayat Tagihan</span>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Akademik</th>
                                <th>Nama Tagihan</th>
                                <th>Tagihan</th>
                                <th>Pembayaran</th>
                                <th>Kekurangan</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in historyPayments" :key="olI">
                                <td>{{ olI+1 }}</td>
                                <td>{{ ol.tahun_akademik }}</td>
                                <td>{{ ol.nama_tagihan }}</td>
                                <td>{{ ol.tagihan }}</td>
                                <td>{{ ol.pembayaran }}</td>
                                <td>{{ ol.kekurangan }}</td>
                                <td>{{ ol.status }}</td>
                            </tr>
                            </tbody>
                        </table>
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
                historyPayments: [
                    {
                        "id": 0,
                        'tahun_akademik': "2023/2024",
                        'nama_tagihan': "September 2023",
                        'tagihan': 1100000,
                        'pembayaran': 1100000,
                        'kekurangan': 0,
                        'status': 'Lunas'
                    }
                ]
            }
        }
    }
</script>