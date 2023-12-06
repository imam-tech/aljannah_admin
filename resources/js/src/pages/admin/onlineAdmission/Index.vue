<template>
    <div>
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item">
                        <!-- if breadcrumb is single--><span>Beranda</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Daftar Pendaftaran Siswa Baru</span></li>
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
                                <label class="form-label">Status Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                <select class="form-control" v-model="formFilter.status_pendaftaran" @change="handleChangeStatusPendaftaran()">
                                    <option value="">--Pilih--</option>
                                    <option :value="os" v-for="(os, osI) in optionStatusPendaftaran" :key="osI">{{ os }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Pembayaran</label>
                                <select class="form-control" v-model="formFilter.status_pembayaran">
                                    <option value="">--Semua Status--</option>
                                    <option :value="os" v-for="(os, osI) in optionStatusPembayaran" :key="osI">{{ os }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-bottom justify-content-end">
                                <button @click="handleGetData()" type="button" class="btn btn-success">
                                    <i class="fas fa-search"></i> Cari
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
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span>Daftar Pendaftaran Siswa Baru</span>
                        <button @click="handleShowNewStudentForm()" type="button" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No Pendaftar</th>
                                <th>Angkatan</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Jenjang</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Pembayaran Pendaftaran</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ol, olI) in onlineAdmissions" :key="olI">
                                <td>{{ ol.nomor_pendaftaran }}</td>
                                <td>{{ ol.angkatan }}</td>
                                <td>{{ ol.nama_lengkap }}</td>
                                <td>{{ ol.jenis_kelamin }}</td>
                                <td>{{ ol.jenjang }}</td>
                                <td>{{ ol.created_at | formatDate }}</td>
                                <td>{{ ol.status_pendaftaran }}</td>
                                <td>
                                    <span v-if="['menunggu verifikasi bukti bayar', 'bukti terverifikasi', 'menunggu verifikasi uang pangkal'].includes(ol.status_pembayaran)">
                                        <button @click="handleShowPaymentConfirm(ol)" class="btn btn-warning">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </span>
                                    {{ ol.status_pembayaran }}
                                </td>
                                <td>
                                    <button v-if="ol.status_pendaftaran === 'menunggu verifikasi data'" type="button" @click="handleShowNewStudentForm(ol)" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" @click="handleShowDetail(ol)" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button v-if="ol.status_pendaftaran === 'data terverifikasi' && ol.status_pembayaran === 'bukti terverifikasi'"
                                            @click="handleConfirmWawancara('lolos wawancara', ol.id)" type="button" class="btn btn-warning">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button v-if="ol.status_pendaftaran === 'data terverifikasi' && ol.status_pembayaran === 'bukti terverifikasi'"
                                            @click="handleConfirmWawancara('tidak lolos wawancara', ol.id)" type="button" class="btn btn-danger">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-end">
                                    <pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="handleGetData"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <div class="modal fade" id="detailDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div v-if="detailRegistrationData" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informasi Pendaftar</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td colspan="3" class="bg-primary rounded-2"></td>
                            </tr>
                            <tr>
                                <td>Status Pendaftaran</td>
                                <td colspan="2" class="text-end">{{ detailRegistrationData.status_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td colspan="2" class="text-end">{{ detailRegistrationData.status_pembayaran }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="row">
                                        <div v-if="detailRegistrationData.proven_pendaftaran" class="col-md-6">
                                            <table>
                                                <tr>
                                                    <td colspan="3" class="text-center">Detail Pembayaran pendaftaran</td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah yang dibayar</td>
                                                    <td>: </td>
                                                    <td>Rp. {{ detailRegistrationData.proven_pendaftaran.jumlah_bayar | formatPrice }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nomor_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nama_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nomor_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.nama_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Transfer</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_pendaftaran.tanggal_bayar}}</td>
                                                </tr>
                                                <tr>
                                                    <td>File Bukti Bayar</td>
                                                    <td>: </td>
                                                    <td><a :href="detailRegistrationData.proven_pendaftaran.file_bukti_bayar"><i class="fas fa-link"></i></a></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div v-if="detailRegistrationData.proven_bpms" class="col-md-6">
                                            <table>
                                                <tr>
                                                    <td colspan="3" class="text-center">Detail Pembayaran Uang Pangkal</td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah yang dibayar</td>
                                                    <td>: </td>
                                                    <td>Rp. {{ detailRegistrationData.proven_bpms.jumlah_bayar | formatPrice }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nomor_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Tujuan</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nama_rekening_tujuan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nomor_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Rekening Pengirim</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.nama_rekening_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Transfer</td>
                                                    <td>: </td>
                                                    <td>{{ detailRegistrationData.proven_bpms.tanggal_bayar}}</td>
                                                </tr>
                                                <tr>
                                                    <td>File Bukti Bayar</td>
                                                    <td>: </td>
                                                    <td><a :href="detailRegistrationData.proven_bpms.file_bukti_bayar"><i class="fas fa-link"></i></a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Pendaftaran</td>
                                <td colspan="2" class="text-end">{{ detailRegistrationData.nomor_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary rounded-2"></td>
                            </tr>
                            <tr>
                                <td rowspan="4" class="align-middle">
                                    <i class="fas fa-clipboard"></i> Informasi Pendaftaran
                                </td>
                                <td>Jenis Pendaftaran</td>
                                <td class="text-end">{{ detailRegistrationData.jenis_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Gelombang</td>
                                <td class="text-end">{{ detailRegistrationData.gelombang_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Jenjang</td>
                                <td class="text-end">{{ detailRegistrationData.jenjang }}</td>
                            </tr>
                            <tr>
                                <td>Jalur Pendaftaran</td>
                                <td class="text-end">{{ detailRegistrationData.jalur_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary rounded-2"></td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="align-middle">
                                    <i class="fas fa-user"></i> Informasi Pribadi
                                </td>
                                <td>Nama Lengkap</td>
                                <td class="text-end">{{ detailRegistrationData.nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td class="text-end">{{ detailRegistrationData.nomor_induk_kependudukan }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td class="text-end">{{ detailRegistrationData.jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td class="text-end">{{ detailRegistrationData.tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td class="text-end">{{ detailRegistrationData.tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Berat Badan</td>
                                <td class="text-end">{{ detailRegistrationData.berat_badan }} kg</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary rounded-2"></td>
                            </tr>
                            <tr>
                                <td rowspan="6" class="align-middle">
                                    <i class="fas fa-user-friends"></i> Informasi Orang Tua
                                </td>
                                <td>Nama Lengkap Ayah</td>
                                <td class="text-end">{{ detailRegistrationData.nama_ayah }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap Ibu</td>
                                <td class="text-end">{{ detailRegistrationData.nama_ibu }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap Wali</td>
                                <td class="text-end">{{ detailRegistrationData.nama_wali }}</td>
                            </tr>
                            <tr>
                                <td>No Telepon Ayah</td>
                                <td class="text-end">{{ detailRegistrationData.telepon_ayah }}</td>
                            </tr>
                            <tr>
                                <td>No Telepon Ibu</td>
                                <td class="text-end">{{ detailRegistrationData.telepon_ibu }}</td>
                            </tr>
                            <tr>
                                <td>Not Telepon Wali</td>
                                <td class="text-end">{{ detailRegistrationData.telepon_wali }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary rounded-2"></td>
                            </tr>
                            <tr>
                                <td rowspan="4" class="align-middle">
                                    <i class="fas fa-school"></i> Informasi Asal Sekolah
                                </td>
                                <td>Nama Asal Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.nama_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td>Status Asal Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.status_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.alamat_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Lulus</td>
                                <td class="text-end">{{ detailRegistrationData.tahun_lulus_sekolah_sebelumnya }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="bg-primary rounded-2"></td>
                            </tr>
                            <tr>
                                <td rowspan="9" class="align-middle">
                                    <i class="fas fa-house-user"></i> Informasi Tempat Tinggal
                                </td>
                                <td>Kelurahan</td>
                                <td class="text-end">{{ detailRegistrationData.kelurahan }}</td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td class="text-end">{{ detailRegistrationData.kecamatan }}</td>
                            </tr>
                            <tr>
                                <td>Kota/Kabupaten</td>
                                <td class="text-end">{{ detailRegistrationData.kota_atau_kabupaten }}</td>
                            </tr>
                            <tr>
                                <td>Provinsi</td>
                                <td class="text-end">{{ detailRegistrationData.provinsi }}</td>
                            </tr>
                            <tr>
                                <td>Kewarganegaraan</td>
                                <td class="text-end">{{ detailRegistrationData.kewarganegaraan }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Tempat Tinggal</td>
                                <td class="text-end">{{ detailRegistrationData.jenis_tempat_tinggal }}</td>
                            </tr>
                            <tr>
                                <td>Transportasi ke Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.transportasi_ke_sekolah }}</td>
                            </tr>
                            <tr>
                                <td>Jarak ke Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.jarak_ke_sekolah }} km</td>
                            </tr>
                            <tr>
                                <td>Waktu Tempuh ke Sekolah</td>
                                <td class="text-end">{{ detailRegistrationData.waktu_tempuh_ke_sekolah }} menit</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="detailRegistrationData.status_pendaftaran === 'menunggu verifikasi data'" class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="handleConfirmData('data terverifikasi')">
                            <i class="fas fa-check-circle"></i> Ya, Data Benar
                        </button>
                        <button type="button" class="btn btn-danger" @click="handleConfirmData('data tidak valid')">
                            <i class="fas fa-times-circle"></i> Tolak, Data Salah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verificationPaymentModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div v-if="detailPaymentData" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? 'Informasi Bukti Bayar Uang Pangkal' : 'Informasi Bukti Bayar Pendaftaran' }}</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td>Nomor Pendaftaran</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.nomor_pendaftaran }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.status : detailPaymentData.proven_pendaftaran.status }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Bayar</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.tanggal_bayar : detailPaymentData.proven_pendaftaran.tanggal_bayar }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Bayar</td>
                                <td>: </td>
                                <td>
                                    <span v-if="detailPaymentData.status_pendaftaran === 'lolos wawancara'">Rp. {{ detailPaymentData.proven_bpms.jumlah_bayar | formatPrice }}</span>
                                    <span v-else>Rp. {{ detailPaymentData.proven_pendaftaran.jumlah_bayar | formatPrice }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Bukti Bayar</td>
                                <td>: </td>
                                <td><a :href="detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.file_bukti_bayar : detailPaymentData.proven_pendaftaran.file_bukti_bayar" target="_blank"><button class="btn btn-info" type="button">
                                    <i class="fas fa-link"></i>
                                </button></a></td>
                            </tr>
                            <tr>
                                <td>Nama Rekening Tujuan</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nama_rekening_tujuan : detailPaymentData.proven_pendaftaran.nama_rekening_tujuan }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening Tujuan</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nomor_rekening_tujuan : detailPaymentData.proven_pendaftaran.nomor_rekening_tujuan }}</td>
                            </tr>
                            <tr>
                                <td>Nama Rekening Pengirim</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nama_rekening_pengirim : detailPaymentData.proven_pendaftaran.nama_rekening_pengirim }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening Pengirim</td>
                                <td>: </td>
                                <td>{{ detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.nomor_rekening_pengirim : detailPaymentData.proven_pendaftaran.nomor_rekening_pengirim }}</td>
                            </tr>
                            <tr v-if="['menunggu verifikasi bukti bayar', 'menunggu verifikasi uang pangkal'].includes(detailPaymentData.status_pendaftaran === 'lolos wawancara' ? detailPaymentData.proven_bpms.status : detailPaymentData.proven_pendaftaran.status)">
                                <td colspan="3" class="text-center">
                                    <button type="button" @click="handleConfirmProven('bukti terverifikasi')" class="btn btn-primary">
                                        <i class="fas fa-check-circle"></i>Konfirm</button>
                                    <button type="button" @click="handleConfirmProven('bukti tidak valid')" class="btn btn-danger"><i class="fas fa-times-circle"></i>Tolak</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ formData.id !== undefined ? 'Ubah' : 'Tambh' }} Pendaftar</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-white text-center text-dark">
                                        <h3>Tahun Ajaran {{ formData.angkatan }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form  @submit.prevent="handleSubmit">
                                            <div class="card mb-4">
                                                <div class="card-header text-dark">
                                                    <i class="fas fa-clipboard"></i> Informasi Pendaftaran
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-3 mb-3">
                                                            <label class="form-label">Jenis Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                                            <select class="form-control" v-model="formData.jenis_pendaftaran" required>
                                                                <option value="">--Pilih Jenis Pendaftaran--</option>
                                                                <option value="Baru">Baru</option>
                                                                <option value="Pindah">Pindah</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3 mb-3">
                                                            <label class="form-label">Gelombang <span class="text-danger"><b>*)</b></span></label>
                                                            <select class="form-control" v-model="formData.gelombang_pendaftaran" required>
                                                                <option value="">--Pilih Gelombang--</option>
                                                                <option :value="gl" v-for="(gl, glI) in gelombangData" :key="glI">{{ gl }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3 mb-3">
                                                            <label class="form-label">Jenjang/Tujuan <span class="text-danger"><b>*)</b></span></label>
                                                            <select class="form-control" v-model="formData.jenjang" required>
                                                                <option value="">--Pilih Jenjang--</option>
                                                                <option :value="jl" v-for="(jl, jlI) in jenjangData" :key="jlI">{{ jl }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3 mb-3">
                                                            <label class="form-label">Jalur Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                                            <select class="form-control" v-model="formData.jalur_pendaftaran" required>
                                                                <option value="">--Pilih Jalur--</option>
                                                                <option value="Reguler">Reguler</option>
                                                                <option value="Prestasi Full">Prestasi Full</option>
                                                                <option value="Prestasi Non Full">Prestasi Non Full</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-4">
                                                <div class="card-header text-dark">
                                                    <i class="fas fa-user"></i> Informasi Pribadi
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Nama Lengkap <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.nama_lengkap" class="form-control" placeholder="Nama Lengkap Anda" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">NIK <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.nomor_induk_kependudukan" class="form-control" placeholder="Nomor Induk Kependudukan" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Jenis Kelamin <span class="text-danger"><b>*)</b></span></label>
                                                            <select class="form-control" v-model="formData.jenis_kelamin" required>
                                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                                <option value="Laki-Laki">Laki-Laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Tempat Lahir <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.tempat_lahir" class="form-control" placeholder="Contoh: Bogor" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Tanggal Lahir <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="date" v-model="formData.tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Berat Badan (gram)</label>
                                                            <input type="number" v-model="formData.berat_badan" class="form-control" placeholder="Contoh 60.5, (60.5 kg)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-4">
                                                <div class="card-header text-dark">
                                                    <i class="fas fa-user-friends"></i> Informasi Orang Tua
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Nama Lengkap Ayah <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.nama_ayah" class="form-control" placeholder="Nama Ayah Anda" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Nama Lengkap Ibu <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.nama_ibu" class="form-control" placeholder="Nama Ibu Anda" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">Nama Lengkap Wali</label>
                                                            <input type="text" v-model="formData.nama_wali" class="form-control" placeholder="Isi ketika Anda menggunakan Wali">
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">No Telepon Ayah <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.telepon_ayah" class="form-control" placeholder="Contoh: 08123***" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">No Telepon Ibu <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.telepon_ibu" class="form-control" placeholder="Contoh: 08123***" required>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label class="form-label">No Telepon Wali</label>
                                                            <input type="text" v-model="formData.telepon_wali" class="form-control" placeholder="Isi ketika Anda menggunakan Wali">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-4">
                                                <div class="card-header text-dark">
                                                    <i class="fas fa-school"></i> Informasi Asal Sekolah
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Nama Asal Sekolah <span v-if="['SMP', 'SMA'].includes(formData.jenjang)" class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.nama_sekolah_sebelumnya" class="form-control" placeholder="Sekolah Sebelumnya" :required="['SMP', 'SMA'].includes(formData.jenjang) ? true : false">
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Status Asal Sekolah <span v-if="['SMP', 'SMA'].includes(formData.jenjang)" class="text-danger"><b>*)</b></span></label>
                                                            <select v-model="formData.status_sekolah_sebelumnya" class="form-control" :required="['SMP', 'SMA'].includes(formData.jenjang) ? true : false">
                                                                <option value="">-- Pilih Status --</option>
                                                                <option value="Swasta">Swasta</option>
                                                                <option value="Negeri">Negeri</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-8 mb-3">
                                                            <label class="form-label">Alamat Asal Sekolah <span v-if="['SMP', 'SMA'].includes(formData.jenjang)" class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" v-model="formData.alamat_sekolah_sebelumnya" class="form-control" placeholder="Alamat lengkap sekolah sebelumnya" :required="['SMP', 'SMA'].includes(formData.jenjang) ? true : false">
                                                        </div>
                                                        <div class="col-lg-4 mb-3">
                                                            <label class="form-label">Tahun Lulus <span v-if="['SMP', 'SMA'].includes(formData.jenjang)" class="text-danger"><b>*)</b></span></label>
                                                            <select v-model="formData.tahun_lulus_sekolah_sebelumnya" class="form-control" :required="['SMP', 'SMA'].includes(formData.jenjang) ? true : false">
                                                                <option value="">--Pilih--</option>
                                                                <option :value="th" v-for="(th, thI) in tahunLulus" :key="thI">{{ th }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <span class="text-danger">Wajib Diisi ketika Anda memilih jenjang SMP atau SMA</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-4">
                                                <div class="card-header text-dark">
                                                    <i class="fas fa-house-user"></i> Informasi Tempat Tinggal
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Kelurahan <span class="text-danger"><b>*)</b></span></label>
                                                            <input v-model="formData.kelurahan" type="text" class="form-control" placeholder="Contoh: Kelurahan Mampang" required>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Kecamatan/Kota/Kabupaten <span class="text-danger"><b>*)</b></span></label>
                                                            <input type="text" @keyup="handleSearchSubdistrict()" v-model="keywordAddress" class="form-control" placeholder="Silahkan cari kecamatan, kabupaten atau kota Anda" required>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Alamat <span class="text-danger"><b>*)</b></span></label>
                                                            <select @change="handleChooseAddress()" v-model="chooseAddress" class="form-control" required>
                                                                <option value="">--Pilih--</option>
                                                                <option :value="ao" v-for="(ao, aoI) in addressOptions" :key="aoI">{{ ao }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Kewarganegaraan <span class="text-danger"><b>*)</b></span></label>
                                                            <input v-model="formData.kewarganegaraan" type="text" class="form-control" value="Indonesia" required>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Jenis Tempat Tinggal</label>
                                                            <input v-model="formData.jenis_tempat_tinggal" type="text" class="form-control" placeholder="Contoh: Rumah Sendiri">
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Transportasi ke Sekolah</label>
                                                            <input v-model="formData.transportasi_ke_sekolah" type="text" class="form-control" placeholder="Contoh: Sepeda Motor">
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Jarak ke Sekolah (satuan Km)</label>
                                                            <input v-model="formData.jarak_ke_sekolah" type="number" class="form-control" placeholder="Contoh: 10 (10 km)">
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Waktu Tempuh ke Sekolah (satuan menit)</label>
                                                            <input v-model="formData.waktu_tempuh_ke_sekolah" type="number" class="form-control" placeholder="Contoh: 30 (30 menit)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="text-danger">*) Harus Diisi</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <a href="/online-admission/form" class="btn btn-secondary" v-if="$route.params.type !== 'form'">
                                                        <i class="fas fa-arrow-left"></i> Batal
                                                    </a>
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-save"></i> Simpan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-->
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
                detailRegistrationData: null,
                detailPaymentData: null,
                onlineAdmissions: [],
                formFilter: {
                    status_pendaftaran: '',
                    status_pembayaran: ''
                },
                optionStatusPendaftaran: [
                    'menunggu verifikasi data', 'data terverifikasi', 'lolos wawancara'
                ],
                optionStatusPembayaran: [],
                formData: {
                    "angkatan": '2023/2024',
                    "jenis_pendaftaran": "",
                    "gelombang_pendaftaran": "",
                    "jenjang": "",
                    "jalur_pendaftaran": "",
                    "nama_lengkap": "",
                    "nomor_induk_kependudukan": "",
                    "jenis_kelamin": "",
                    "tempat_lahir": "",
                    "tanggal_lahir": "",
                    "berat_badan": "",
                    "nama_ayah": "",
                    "nama_ibu": "",
                    "nama_wali": "",
                    "telepon_ayah": "",
                    "telepon_ibu": "",
                    "telepon_wali": "",
                    "nama_sekolah_sebelumnya": "",
                    "status_sekolah_sebelumnya": "",
                    "alamat_sekolah_sebelumnya": "",
                    "tahun_lulus_sekolah_sebelumnya": "",
                    "kelurahan": "",
                    "kecamatan": "",
                    "kota_atau_kabupaten": "",
                    "provinsi": "",
                    "kewarganegaraan": "Indonesia",
                    "jenis_tempat_tinggal": "",
                    "transportasi_ke_sekolah": "",
                    "jarak_ke_sekolah": "",
                    "waktu_tempuh_ke_sekolah": "",
                },
                jenjangData: [],
                gelombangData: [],
                addressOptions: [],
                keywordAddress: "",
                chooseAddress: "",
                tahunLulus: [],
                page: 1,
                totalData: 0,
                perPage: 0,
            }
        },
        mounted() {
            let yearBefore = new Date().getFullYear() - 1;
            for (yearBefore; yearBefore > (new Date().getFullYear()-10); yearBefore--) {
                this.tahunLulus.push(yearBefore)
            }
            this.handleGetData()
            this.handleJenjang();
        },
        methods: {
            async handleSubmit() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.post(`api/ppdb`, this.formData)
                    this.$vs.loading.close()
                    if (resp.status) {
                        $("#addDataModal").modal("hide")
                        this.handleGetData()
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
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

            handleShowNewStudentForm(ol = null) {
                if (ol) {
                    this.formData = ol
                    this.keywordAddress = ol.kecamatan
                    const optAdd = ol.kecamatan + ', ' + ol.kota_atau_kabupaten + ', ' + ol.provinsi
                    this.addressOptions = [optAdd]
                    this.chooseAddress = optAdd
                } else {
                    this.formData =  {
                        "angkatan": '2023/2024',
                        "jenis_pendaftaran": "",
                        "gelombang_pendaftaran": "",
                        "jenjang": "",
                        "jalur_pendaftaran": "",
                        "nama_lengkap": "",
                        "nomor_induk_kependudukan": "",
                        "jenis_kelamin": "",
                        "tempat_lahir": "",
                        "tanggal_lahir": "",
                        "berat_badan": "",
                        "nama_ayah": "",
                        "nama_ibu": "",
                        "nama_wali": "",
                        "telepon_ayah": "",
                        "telepon_ibu": "",
                        "telepon_wali": "",
                        "nama_sekolah_sebelumnya": "",
                        "status_sekolah_sebelumnya": "",
                        "alamat_sekolah_sebelumnya": "",
                        "tahun_lulus_sekolah_sebelumnya": "",
                        "kelurahan": "",
                        "kecamatan": "",
                        "kota_atau_kabupaten": "",
                        "provinsi": "",
                        "kewarganegaraan": "Indonesia",
                        "jenis_tempat_tinggal": "",
                        "transportasi_ke_sekolah": "",
                        "jarak_ke_sekolah": "",
                        "waktu_tempuh_ke_sekolah": "",
                    }
                }
                $("#addDataModal").modal("show")
            },

            async handleJenjang() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/ppdb/jenjang-data`)
                    this.$vs.loading.close()
                    this.gelombangData = resp.gelombang;
                    this.jenjangData = resp.jenjang;
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

            async handleSearchSubdistrict() {
                try {
                    if (this.keywordAddress.length < 3) {
                        return
                    }
                    const resp = await this.$axios.get(`api/general/address/search-subdistrict?keyword=${this.keywordAddress}`)
                    this.addressOptions = resp;
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

            handleChooseAddress() {
                console.log("hand")
                const arr = this.chooseAddress.split(", ")
                this.formData.kecamatan = arr[0]
                this.formData.kota_atau_kabupaten = arr[1]
                this.formData.provinsi = arr[2]
            },

            handleChangeStatusPendaftaran() {
                if (['menunggu verifikasi data',''].includes(this.formFilter.status_pendaftaran)) {
                    this.optionStatusPembayaran = [];
                } else if (this.formFilter.status_pendaftaran === 'data terverifikasi') {
                    this.optionStatusPembayaran = ['menunggu pembayaran pendaftaran', 'menunggu verifikasi bukti bayar', 'bukti terverifikasi'];
                } else if (this.formFilter.status_pendaftaran === 'lolos wawancara') {
                    this.optionStatusPembayaran = ['menunggu pembayaran uang pangkal', 'menunggu verifikasi uang pangkal', 'bukti terverifikasi'];
                }
            },

            async handleGetData() {
                try {
                    const filters = new URLSearchParams(this.formFilter).toString()
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/ppdb?page=${this.page}&${filters}`)
                    this.onlineAdmissions = resp.data
                    this.totalData = resp.total
                    this.page = resp.current_page
                    this.perPage = resp.per_page
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

            handleShowPaymentConfirm(ol) {
                this.detailPaymentData = ol
                $("#verificationPaymentModal").modal('show')
            },

            handleShowDetail(ol) {
                this.detailRegistrationData = ol
                $("#detailDataModal").modal("show")
            },

            handleConfirmData(type) {
                $("#detailDataModal").modal("hide")
                let title = "Apakah Anda yakin data calon siswa tidak valid?";
                if (type === 'data terverifikasi') {
                    title = "Apakah Anda yakin data calon siswa sudah valid? Notifikasi akan dikirim ke email atau no telepon untuk melakukan pembayaran pendaftaran.";
                }
                Swal.fire({
                    icon: 'info',
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        try {
                            this.$vs.loading();
                            const resp = await this.$axios.post(`api/ppdb/verify`, {
                                id: this.detailRegistrationData.id,
                                type: type
                            })
                            this.$vs.loading.close()
                            if (!resp.status) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: resp.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                this.handleGetData()
                            }
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
                    } else {
                        $("#detailDataModal").modal("show")
                    }
                })
            },

            handleConfirmProven(type) {
                $("#verificationPaymentModal").modal("hide")
                let title = "Apakah Anda yakin bukti bayar tidak valid?";
                if (type === 'bukti terverifikasi') {
                    title = "Apakah Anda yakin bukti bayar sudah valid?.";
                }
                Swal.fire({
                    icon: 'info',
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        try {
                            this.$vs.loading();
                            const resp = await this.$axios.post(`api/ppdb/${this.detailPaymentData.status_pendaftaran === 'lolos wawancara' ? 'uang pangkal' : 'pendaftaran'}/verify-proven`, {
                                id: this.detailPaymentData.status_pendaftaran === 'lolos wawancara' ? this.detailPaymentData.proven_bpms.id : this.detailPaymentData.proven_pendaftaran.id,
                                type: type
                            })
                            this.$vs.loading.close()
                            if (!resp.status) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: resp.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                this.handleGetData()
                            }
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
                    } else {
                        $("#verificationPaymentModal").modal("show")
                    }
                })
            },

            handleConfirmWawancara(type, id) {
                let title = "Apakah Anda yakin pendaftar ini tidak lolos tes wawancara?";
                if (type === 'lolos wawancara') {
                    title = "Apakah Anda yakin pendaftar ini lolos tes wawancara?";
                }
                Swal.fire({
                    icon: 'info',
                    title: title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        try {
                            this.$vs.loading();
                            const resp = await this.$axios.post(`api/ppdb/verify-interview`, {
                                id: id,
                                type: type
                            })
                            this.$vs.loading.close()
                            if (!resp.status) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: resp.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            } else {
                                this.handleGetData()
                            }
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
                    }
                })
            }
        }
    }
</script>