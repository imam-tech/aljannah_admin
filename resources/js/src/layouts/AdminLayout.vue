<template>
    <div>
        <Navbar />
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <Topbar />
            <div class="body flex-grow-1 px-3">
                <router-view />
            </div>
            <footer class="footer">
                <div>Aljannah© 2023 <a href="https://imampro.id">imampro.id.</a></div>
            </footer>
        </div>
    </div>
</template>
<script>
    import Topbar from '../components/Topbar.vue'
    import Navbar from '../components/Navbar.vue'
    import LogoutBar from '../components/LogoutBar.vue'

    export default {
        name: "ParentLayout",
        components: {
            Topbar, Navbar, LogoutBar
        }
    }
</script>