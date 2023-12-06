<template>
    <div class="container-lg mt-5">
        <!-- /.row-->
        <div class="row">
            <div class="col-12">
                <p v-if="$route.params.type === 'form'" class="text-danger">
                    <i>Jika Anda sudah melakukan pendaftaran dan sudah menerima no pendaftaran dan password silahkan klik icon sebelah
                        <a href="#" @click.prevent="handleShowModalSearch()">
                            <i class="fas fa-search"></i> Cari
                        </a>
                    </i>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-white text-center text-dark">
                        <h2>{{ labelForm }}</h2>
                        <h3>Tahun Ajaran {{ formData.angkatan }}</h3>
                    </div>
                    <div class="card-body">
                        <form  @submit.prevent="handleConfirmData">
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
                                <AdmissionMainInfo :labelData="labelData" @handleGetDetail="handleShowData" :detailRegistrationData="detailRegistrationData" />
                            </div>
                        </div>
                    </div>
                    <div v-if="detailRegistrationData" class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">
                            <i class="fas fa-times"></i> Tutup
                        </button>
                        <button @click="handleSubmit()" v-if="labelData === 'Konfirmasi Informasi'" type="button" class="btn btn-primary">
                            <i class="fas fa-save"></i> Ok, Simpan
                        </button>
                        <a :href="'/online-admission/' + detailRegistrationData.nomor_pendaftaran" v-else>
                            <button v-if="detailRegistrationData.status_pendaftaran === 'menunggu verifikasi data'" type="button" class="btn btn-warning">
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
                    <form @submit.prevent="handleShowData">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Pendaftaran <span class="text-danger"><b>*)</b></span></label>
                                        <input type="text" v-model="formSearchRegister.registration_number" class="form-control" placeholder="Contoh: A-2023-1" required>
                                        <label class="text-danger"><i>Nomor didapatkan ketika data Anda sukses disimpan</i></label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger"><b>*)</b></span></label>
                                        <input type="date" v-model="formSearchRegister.date_of_birth" class="form-control" placeholder="Tanggal Lahir Anda" required>
                                        <label class="text-danger"><i>Tanggal lahir didapatkan ketika Anda mengisi data pendaftaran</i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">
                                <i class="fas fa-times"></i> Tutup
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="successSubmitModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div v-if="successSubmitData" class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p>Data Anda berhasil diproses dengan nomor daftar <span class="text-dange"><b><i>{{ successSubmitData.nomor_pendaftaran }}</i></b></span></p>
                                <p>Silahkan menggunakan kombinasi nomor pendaftaran dan tanggal lahir untuk mencari data Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <router-link to="/online-admission/form">
                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">
                                <i class="fas fa-times"></i> Tutup
                            </button>
                        </router-link>
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
                tahunLulus: [],
                formSearchRegister: {
                    registration_number: "D-2023-2",
                    date_of_birth: "2023-12-02"
                },
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
                detailRegistrationData: null,
                addressOptions: [],
                keywordAddress: "",
                chooseAddress: "",
                successSubmitData: '',
            }
        },
        created() {
            let yearBefore = new Date().getFullYear() - 1;
            for (yearBefore; yearBefore > (new Date().getFullYear()-10); yearBefore--) {
                this.tahunLulus.push(yearBefore)
            }
            this.handleJenjang();
            if (this.$route.params.type !== 'form') {
                this.labelForm = 'Ubah Data Siswa Baru';
                this.handleGetDetail()
            }
        },
        methods: {
            handleConfirmData() {
                this.labelData = 'Konfirmasi Informasi'
                this.detailRegistrationData = this.formData
                $("#confirmDataModal").modal("show")
            },

            handleShowModalSearch() {
                $("#searchDataModal").modal("show")
            },

            async handleShowData() {
                try {
                    $("#searchDataModal").modal("hide")
                    this.labelData = 'Pendaftaran Informasi'

                    this.$vs.loading();
                    const resp = await this.$axios.post(`api/ppdb/search-registration`, this.formSearchRegister)
                    this.$vs.loading.close()
                    if (!resp.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return
                    }
                    if (resp.data.status_pendaftaran === 'lolos wawancara') {
                        resp.data.jumlah_bayar = 1000000
                    } else {
                        resp.data.jumlah_bayar = 500000
                    }
                    this.detailRegistrationData = resp.data
                    $("#confirmDataModal").modal("show")
                } catch (e) {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    return
                }
            },

            async handleSubmit() {
                try {
                    this.$vs.loading();
                    const resp = await this.$axios.post(`api/ppdb`, this.formData)
                    this.$vs.loading.close()
                    if (resp.status) {
                        this.successSubmitData = resp.data
                        $("#confirmDataModal").modal("hide")
                        $("#successSubmitModal").modal("show")
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

            async handleGetDetail() {
                try {
                    const resp = await this.$axios.get(`api/ppdb/${this.$route.params.type}/detail`)
                    if (!resp.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return
                    }
                    if (resp.data.status_pendaftaran !== 'menunggu verifikasi data') {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: "Data Anda sudah tidak bisa diubah karena status sudah diproses, status terakhir: " + resp.data.status_pendaftaran,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return
                    }
                    this.formData = resp.data
                    this.keywordAddress = resp.data.kecamatan
                    const optAdd = resp.data.kecamatan + ', ' + resp.data.kota_atau_kabupaten + ', ' + resp.data.provinsi
                    this.addressOptions = [optAdd]
                    this.chooseAddress = optAdd
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