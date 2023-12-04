<template>
    <table v-if="detailRegistrationData" class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Informasi</th>
            <th class="text-center">Judul</th>
            <th class="text-center">Info</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="labelData !== 'Konfirmasi Informasi'">
            <td class="text-danger"><b>Status Pendaftaran</b></td>
            <td colspan="2">
                <span class="text-danger">
                    <i><b>
                        {{ detailRegistrationData.status_pendaftaran }}
                    </b></i>
                </span>
            </td>
        </tr>
        <tr v-if="['menunggu pembayaran pendaftaran'].includes(detailRegistrationData.status_pembayaran)">
            <td class="text-danger">Silahkan melakukan pembayaran pendaftaran</td>
            <td colspan="2">
                <ul>
                    <li>Jumlah: Rp. {{ detailRegistrationData.jumlah_bayar }}</li>
                    <li>Bank: CIMB</li>
                    <li>Nomor Rekening: 12312312</li>
                    <li>Jika Anda sudah mentransfer pembayaran silahkan upload bukti <button @click="handleShowUploadForm('pendaftaran')" class="btn btn-warning">di sini</button></li>
                </ul>
                <div v-if="showBuktiBayarForm">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nomor Rekening Tujuan <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nomor_rekening_tujuan" type="text" class="form-control" placeholder="Contoh: Nomor Rekening Sekolah">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nama Rekening Tujuan <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nama_rekening_tujuan" type="text" class="form-control" placeholder="Contoh:CIMB">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nomor Rekening Pengirim <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nomor_rekening_pengirim" type="text" class="form-control" placeholder="Contoh: Nomor Rekening Anda">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nama Rekening Pengirim <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nama_rekening_pengirim" type="text" class="form-control" placeholder="Contoh: BCA">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">File Bukti Bayar <span class="text-danger"><b>*)</b></span></label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Tanggal Bayar <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.tanggal_bayar" type="date" class="form-control">
                        </div>
                        <button type="button" @click="handleUploadBukti()" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Bukti
                        </button>
                    </div>
                </div>
            </td>
        </tr>
        <tr v-if="['menunggu verifikasi bukti bayar', 'bukti terverifikasi'].includes(detailRegistrationData.status_pembayaran)">
            <td class="text-danger">Anda telah melakukan pembayaran</td>
            <td colspan="2">
                <table>
                    <tr>
                        <td>Status Bukti Bayar</td>
                        <td>: </td>
                        <td>{{ detailRegistrationData.proven_pendaftaran.status}}</td>
                    </tr>
                    <tr>
                        <td>Jumlah yang dibayar</td>
                        <td>: </td>
                        <td>Rp. 500.000</td>
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
                    <tr v-if="detailRegistrationData.proven_pendaftaran.status === 'menunggu verifikasi bukti bayar'">
                        <td colspan="3" class="text-center">
                            Jika Anda ingin mengupload ulang bukti bayar, silahkan hapus bukti bayar Anda sebelumnya dengan mengklik tombol sebelah
                            <button class="btn btn-warning" @click="handleReupload()">Upload Ulang</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr v-if="['menunggu pembayaran uang pangkal'].includes(detailRegistrationData.status_pembayaran)">
            <td class="text-danger">Silahkan melakukan pembayaran uang pangkal</td>
            <td colspan="2">
                <ul>
                    <li>Jumlah: Rp. {{ detailRegistrationData.jumlah_bayar }}</li>
                    <li>Bank: CIMB</li>
                    <li>Nomor Rekening: 12312312</li>
                    <li>Jika Anda sudah mentransfer pembayaran silahkan upload bukti <button @click="handleShowUploadForm('uang pangkal')" class="btn btn-primary">di sini</button></li>
                </ul>
                <div v-if="showBuktiBayarForm">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nomor Rekening Tujuan <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nomor_rekening_tujuan" type="text" class="form-control" placeholder="Contoh: Nomor Rekening Sekolah">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nama Rekening Tujuan <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nama_rekening_tujuan" type="text" class="form-control" placeholder="Contoh:CIMB">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nomor Rekening Pengirim <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nomor_rekening_pengirim" type="text" class="form-control" placeholder="Contoh: Nomor Rekening Anda">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nama Rekening Pengirim <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.nama_rekening_pengirim" type="text" class="form-control" placeholder="Contoh: BCA">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">File Bukti Bayar <span class="text-danger"><b>*)</b></span></label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Tanggal Bayar <span class="text-danger"><b>*)</b></span></label>
                            <input v-model="formUploadBukti.tanggal_bayar" type="date" class="form-control">
                        </div>
                        <button type="button" @click="handleUploadBukti('uang pangkal')" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Bukti
                        </button>
                    </div>
                </div>
            </td>
        </tr>
        <tr v-if="['menunggu verifikasi uang pangkal', 'uang pangkal terverifikasi'].includes(detailRegistrationData.status_pembayaran)">
            <td class="text-danger">Anda telah melakukan pembayaran uang pangkal</td>
            <td colspan="2">
                <table>
                    <tr>
                        <td>Status Bukti Bayar</td>
                        <td>: </td>
                        <td>{{ detailRegistrationData.proven_bpms.status}}</td>
                    </tr>
                    <tr>
                        <td>Jumlah yang dibayar</td>
                        <td>: </td>
                        <td>{{ detailRegistrationData.proven_bpms.status}}</td>
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
                    <tr v-if="detailRegistrationData.proven_bpms.status === 'menunggu verifikasi uang pangkal'">
                        <td colspan="3" class="text-center">
                            Jika Anda ingin mengupload ulang uang pangkal, silahkan hapus bukti bayar Anda sebelumnya dengan mengklik tombol sebelah
                            <button class="btn btn-warning" @click="handleReupload('uang pangkal')">Upload Ulang</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="bg-primary"></td>
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
            <td colspan="3" class="bg-primary"></td>
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
            <td colspan="3" class="bg-primary"></td>
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
            <td colspan="3" class="bg-primary"></td>
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
            <td colspan="3" class="bg-primary"></td>
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
        <tr>
            <td colspan="3" class="bg-primary"></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center text-danger">
                <i><h2>Pastikan data yang Anda masukkan adalah yang sebenar-benarnya, jika ada kesalahan data maka Anda siap bertanggungjawab</h2></i>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "AdmissionMainInfo",
        props: ['labelData', 'detailRegistrationData'],
        data() {
            return {
                showBuktiBayarForm: false,
                formUploadBukti: {
                    ppdb_registration_id: "",
                    nomor_rekening_tujuan: '',
                    nama_rekening_tujuan: '',
                    nomor_rekening_pengirim: '',
                    nama_rekening_pengirim: '',
                    tanggal_bayar: '',
                    jumlah_bayar: 0,
                    file_bukti_bayar: "https://www.google.com",
                }
            }
        },
        methods: {
            handleShowUploadForm(type) {
                this.formUploadBukti.jumlah_bayar = this.detailRegistrationData.jumlah_bayar
                this.showBuktiBayarForm = !this.showBuktiBayarForm
            },
            async handleReupload(type = 'pendaftaran') {
                try {
                    const idProven = type === 'pendaftaran' ? this.detailRegistrationData.proven_pendaftaran.id : this.detailRegistrationData.proven_bpms.id
                    this.$vs.loading();
                    const resp = await this.$axios.get(`api/ppdb/${this.detailRegistrationData.id}/${idProven}/reupload-proven/${type}`)
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
                        this.$emit("handleGetDetail", "")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
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
            async handleUploadBukti(type = 'pendaftaran') {
                try {
                    this.$vs.loading();
                    this.formUploadBukti.ppdb_registration_id = this.detailRegistrationData.id
                    const resp = await this.$axios.post(`api/ppdb/${type}/upload-proven`, this.formUploadBukti)
                    this.showBuktiBayarForm = false
                    this.formUploadBukti = {
                        ppdb_registration_id: "",
                        nomor_rekening_tujuan: '',
                        nama_rekening_tujuan: '',
                        nomor_rekening_pengirim: '',
                        nama_rekening_pengirim: '',
                        tanggal_bayar: '',
                        file_bukti_bayar: "https://www.google.com",
                    }
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
                        this.$emit("handleGetDetail", "")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
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
            }
        }
    }
</script>