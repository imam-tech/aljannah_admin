<template>
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <i class="fas fa-list-ul"></i>
            </button>
            <a class="header-brand d-md-none" href="#">
                <img src="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/aljannah.png"  width="118" height="46">
            </a>
            <ul class="header-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md">
                            <img class="avatar-img" src="assets/img/avatars/8.jpg" alt="user@email.com">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <button class="dropdown-item">
                            <i class="fas fa-user icon me-2"></i> Profile
                        </button>
                        <button class="dropdown-item" @click="confirmLogout()">
                            <i class="fas fa-sign-out-alt icon me-2"></i> Logout
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </header>
</template>

<script>

    import Cookies from 'js-cookie'

    export default {
        methods: {
            async confirmLogout() {
                let hasLogin = confirm('Are you sure you want to logout?')
                if( hasLogin) {
                    // await this.$axios.get(`api/auth/logout`)
                    Cookies.remove('access_token_aljannah')
                    this.$router.push('/auth/login');
                }
            }
        }

    }
</script>
