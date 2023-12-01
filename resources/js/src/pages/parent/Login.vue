<template>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
                <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                        <h1>Login</h1>
                        <p class="text-medium-emphasis">Silahkan Masukkan Kode Siswa dan Password</p>
                        <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                      </svg></span>
                            <input v-model="formData.code" class="form-control" type="text" placeholder="Kode Siswa">
                        </div>
                        <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                      </svg></span>
                            <input v-model="formData.password" class="form-control" type="password" placeholder="Kata Sandi">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button @click="loginProcess()" class="btn btn-primary px-4" type="button">Login</button>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-link px-0" type="button">Tampilkan Password</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-5 text-white bg-primary">
                    <div class="card-body">
                        <img src="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/aljannah.png" alt="" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Cookies from "js-cookie";

    export default {
        name: "Login.vue",
        data() {
            return {
                formData: {
                    code: "",
                    password: ""
                }
            }
        },
        methods: {
            async loginProcess() {
                try {
                    this.$router.push('/parent');
                    // this.$vs.loading();
                    // const responseLogin = await this.$axios.post(`api/parent/auth/login`, this.formData)
                    // console.log("resp", responseLogin);
                    // this.$vs.loading.close()
                    // if (responseLogin.status) {
                    //     Swal.fire({
                    //         position: 'top',
                    //         icon: 'success',
                    //         title: "success",
                    //         showConfirmButton: false,
                    //         timer: 1500
                    //     }).then(()=>{
                    //         this.$store.commit('SET_USER', {
                    //             'name' : responseLogin.data.user.name,
                    //             'email' : responseLogin.data.user.email
                    //         })
                    //         this.$store.commit('SET_LOGIN', true)
                    //         Cookies.set('access_token_parent_aljannah', responseLogin.data.token, { expires: 1 })
                    //         this.$router.push('/app');
                    //     })
                    // } else {
                    //     Swal.fire({
                    //         position: 'top-end',
                    //         icon: 'error',
                    //         title: responseLogin.message,
                    //         showConfirmButton: false,
                    //         timer: 1500
                    //     })
                    // }
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