<template>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
                <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                        <form @submit.prevent="loginProcess">
                            <h1>Login</h1>
                            <p class="text-medium-emphasis">Sign In to your account</p>
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input v-model="formData.email" class="form-control" type="text" placeholder="Email" required>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text">
                                    <i :class="!showPassword ? 'fas fa-lock' : 'fas fa-lock-open'"></i>
                                </span>
                                <input v-model="formData.password" class="form-control" :type="showPassword ? 'text' : 'password'" placeholder="Password" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-link px-0" type="button" @click="handleChangeShowPassword()">Show password</button>
                                </div>
                            </div>
                        </form>
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
                    email: "",
                    password: ""
                },
                showPassword: false
            }
        },
        methods: {
            handleChangeShowPassword() {
                this.showPassword = !this.showPassword
            },
            async loginProcess() {
                try {
                    this.$vs.loading();
                    const responseLogin = await this.$axios.post(`api/auth/login`, this.formData)
                    console.log("resp", responseLogin);
                    this.$vs.loading.close()
                    if (responseLogin.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: "success",
                            showConfirmButton: false,
                            timer: 3000
                        }).then(()=>{
                            this.$store.commit('SET_USER', {
                                'name' : responseLogin.data.user.name,
                                'email' : responseLogin.data.user.email,
                                // 'permissions' : responseLogin.data.permissions,
                                // 'roles' : responseLogin.data.role,
                                // 'sign_at': responseLogin.data.sign_at
                            })
                            this.$store.commit('SET_LOGIN', true)
                            Cookies.set('access_token_aljannah', responseLogin.data.token, { expires: 1 })
                            this.$router.push('/app');
                        })
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: responseLogin.message,
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