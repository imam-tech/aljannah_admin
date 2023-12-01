<template>

    <div class="sidebar sidebar-dark sidebar-fixed bg-success" id="sidebar">
        <div class="sidebar-brand d-none d-md-flex">
            <img src="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/aljannah.png"  class="sidebar-brand-full" width="118" height="46">
            <img src="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/aljannah.png"  class="sidebar-brand-narrow" width="48" height="26">
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item">
                <router-link class="nav-link text-dark" to="/parent/app">
                    <i class="fas fa-home nav-icon text-dark"></i> Beranda
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/parent/app/profile">
                    <i class="fas fa-user-md nav-icon"></i> Profil
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/parent/app/payment">
                    <i class="fas fa-dollar-sign nav-icon"></i> Keuangan
                </router-link>
            </li>
        </ul>
        <!--<button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>-->
    </div>
</template>