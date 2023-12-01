<template>
    <div class="container-lg mt-5">
        <!-- /.row-->
        <div class="row">
            <div class="col-12">
                <p v-if="$route.params.type === 'form'" class="text-danger">
                    <i>Jika Anda sudah melakukan pendaftaran dan sudah menerima no pendaftaran dan password silahkan klik icon sebelah
                        <a href="#" @click.prevent="handleSearchData()">
                            <i class="fas fa-search"></i> Cari
                        </a>
                    </i>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-white text-center text-dark"><h2>{{ labelForm }}</h2></div>
                    <div class="card-body">
                        <div class="card mb-4">
                            <div class="card-header text-dark">
                                <i class="fas fa-clipboard"></i> Informasi Pendaftaran
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <label class="form-label">Jenis Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                        <select class="form-control" v-model="formData.jenis_pendaftaran">
                                            <option value="">--Pilih Jenis Pendaftaran--</option>
                                            <option value="Baru">Baru</option>
                                            <option value="Pindah">Pindah</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <label class="form-label">Gelombang <span class="text-danger"><b>*)</b></span></label>
                                        <select class="form-control" v-model="formData.gelombang_pendaftaran">
                                            <option value="">--Pilih Gelombang--</option>
                                            <option :value="gl" v-for="(gl, glI) in gelombangData" :key="glI">{{ gl }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <label class="form-label">Jenjang/Tujuan <span class="text-danger"><b>*)</b></span></label>
                                        <select class="form-control" v-model="formData.jenjang">
                                            <option value="">--Pilih Jenjang--</option>
                                            <option :value="jl" v-for="(jl, jlI) in jenjangData" :key="jlI">{{ jl }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-3">
                                        <label class="form-label">Jalur Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                        <select class="form-control" v-model="formData.jalur_pendaftaran">
                                            <option value="">--Pilih Jalur--</option>
                                            <option value="reguler">Reguler</option>
                                            <option value="prestasi full">Prestasi Full</option>
                                            <option value="prestasi non full">Prestasi Non Full</option>
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
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" v-model="formData.nama" class="form-control" placeholder="Nama Lengkap Anda">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">NIK <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Nomor Induk Kependudukan">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger"><b>*)</b></span></label>
                                        <select class="form-control">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="1">Laki-Laki</option>
                                            <option value="0">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Tempat Lahir <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: Bogor">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger"><b>*)</b></span></label>
                                        <input type="date" class="form-control" placeholder="Tanggal Lahir">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Berat Badan (satuan: gram)</label>
                                        <input type="number" class="form-control" placeholder="Contoh 60.5, (60.5 kg)">
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
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Nama Lengkap Ayah <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Nama Ayah Anda">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Nama Lengkap Ibu <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Nama Ibu Anda">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Nama Lengkap Wali</label>
                                        <input type="text" class="form-control" placeholder="Isi ketika Anda menggunakan Wali">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">No Telepon Ayah <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: 08123***">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">No Telepon Ibu <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: 08123***">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">No Telepon Wali</label>
                                        <input type="text" class="form-control" placeholder="Isi ketika Anda menggunakan Wali">
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
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Nama Asal Sekolah <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Sekolah Sebelumnya">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Status Asal Sekolah <span class="text-danger"><b>*)</b></span></label>
                                        <select class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="swasta">Swasta</option>
                                            <option value="negeri">Negeri</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Alamat Asal Sekolah <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Alamat lengkap sekolah sebelumnya">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Tahun Lulus <span class="text-danger"><b>*)</b></span></label>
                                        <input type="number" class="form-control" placeholder="Tahun Anda Lulus">
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
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Kelurahan <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: Kelurahan Mampang">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Kecamatan <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: Kecamatan Manggarai">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Kota/Kabupaten <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: Kota Bogor">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Provinsi <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" placeholder="Contoh: Jawa Barat">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Kewarganegaraan <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" class="form-control" value="Indonesia">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Jenis Tempat Tinggal</label>
                                        <input type="text" class="form-control" placeholder="Contoh: Rumah Sendiri">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Transportasi ke Sekolah</label>
                                        <input type="text" class="form-control" placeholder="Contoh: Sepeda Motor">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Jarak ke Sekolah (satuan Km)</label>
                                        <input type="number" class="form-control" placeholder="Contoh: 10 (10 km)">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <label class="form-label">Waktu Tempuh ke Sekolah (satuan menit)</label>
                                        <input type="number" class="form-control" placeholder="Contoh: 30 (30 menit)">
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
                                <button @click="handleConfirmData()" class="btn btn-primary" type="button">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <div class="modal fade" id="confirmDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ labelData }}</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <AdmissionMainInfo :labelData="labelData" :detailRegistrationData="detailRegistrationData" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">
                            <i class="fas fa-times"></i> Tutup
                        </button>
                        <button v-if="labelData === 'Konfirmasi Informasi'" type="button" class="btn btn-primary">
                            <i class="fas fa-save"></i> Ok, Simpan
                        </button>
                        <a href="/online-admission/123" v-else>
                            <button v-if="detailRegistrationData.status === 'pending'" type="button" class="btn btn-warning">
                                <i class="fas fa-pen-alt"></i> Ubah Data
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="searchDataModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Informasi</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                    <input type="text" v-model="formSearchRegister.registration_number" class="form-control" placeholder="PPDB001">
                                    <label class="text-danger"><i>Nomor didapatkan ketika data Anda sukses disimpan</i></label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger"><b>*)</b></span></label>
                                    <input type="date" v-model="formSearchRegister.date_of_birth" class="form-control" placeholder="Tanggal Lahir Anda">
                                    <label class="text-danger"><i>Tanggal lahir didapatkan ketika Anda mengisi data pendaftaran</i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">
                            <i class="fas fa-times"></i> Tutup
                        </button>
                        <button type="button" class="btn btn-primary" @click="handleShowData()">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row-->
    </div>
    <!-- /.container-fluid -->
</template>

<script>
    import AdmissionMainInfo from '../../components/AdmissionMainInfo'
    export default {
        name: "Index.vue",
        components: {AdmissionMainInfo},
        data() {
            return {
                jenjangData: [],
                gelombangData: [],
                labelData: 'Konfirmasi Informasi',
                labelForm: 'Penerimaan Siswa Baru',
                formSearchRegister: {
                    registration_number: "",
                    date_of_birth: ""
                },
                formData: {
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
                    "kewarganegaraan": "",
                    "jenis_tempat_tinggal": "",
                    "transportasi_ke_sekolah": "",
                    "jarak_ke_sekolah": "",
                    "waktu_tempuh_ke_sekolah": "",
                },
                detailRegistrationData: null
            }
        },
        created() {
            this.handleJenjang();
            if (this.$route.params.type !== 'form') {
                this.labelForm = 'Ubah Data Siswa Baru';
                this.formData =  {
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
                    "kewarganegaraan": "",
                    "jenis_tempat_tinggal": "",
                    "transportasi_ke_sekolah": "",
                    "jarak_ke_sekolah": "",
                    "waktu_tempuh_ke_sekolah": "",
                }
            }
        },
        methods: {
            handleConfirmData() {
                this.labelData = 'Konfirmasi Informasi'
                this.detailRegistrationData = this.formData
                $("#confirmDataModal").modal("show")
            },
            handleSearchData() {
                $("#searchDataModal").modal("show")
            },
            handleShowData() {
                $("#searchDataModal").modal("hide")
                this.labelData = 'Pendaftaran Informasi'
                if (this.formSearchRegister.registration_number == 'A001') {
                    this.detailRegistrationData = {
                        nama: "Budi",
                        status: "verified"
                    }
                } else {
                    this.detailRegistrationData = {
                        nama: "Joni",
                        status: "pending"
                    }
                }
                $("#confirmDataModal").modal("show")
            },

            async handleSubmit() {
                try {
                    this.$vs.loading();
                    const responseLogin = await this.$axios.post(`api/ppdb`, this.formData)
                    console.log("resp", responseLogin);
                    this.$vs.loading.close()
                    if (responseLogin.status) {

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: responseLogin.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
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
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        }
    }
</script>