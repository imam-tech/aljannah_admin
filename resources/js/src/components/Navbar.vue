<template>

    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        <div class="sidebar-brand d-none d-md-flex">
            <img src="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/aljannah.png"  class="sidebar-brand-full" width="118" height="46">
            <img src="https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/aljannah.png"  class="sidebar-brand-narrow" width="48" height="26">
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item">
                <router-link class="nav-link" to="/app">
                    <i class="fas fa-home nav-icon"></i> Beranda
                </router-link>
            <li class="nav-title">PPDB</li>
            <li class="nav-item">
                <router-link class="nav-link" to="/app/admin/online-admission">
                    <i class="fas fa-clipboard nav-icon"></i> Pendaftar Siswa Baru
                </router-link>
            </li>
            <li class="nav-divider"></li>
            <li class="nav-title">Keuangan</li>
            <li class="nav-group">
                <span class="nav-link nav-group-toggle">
                    <i class="fas fa-database nav-icon"></i> Master Pembayaran
                </span>
                <ul class="nav-group-items">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master-payment/type" target="_top">
                            <i class="fas fa-cubes nav-icon"></i> Jenis Pembayaran
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master-payment/pos" target="_top">
                            <i class="fas fa-cube nav-icon"></i> Pos Pembayaran
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master-payment/tariff" target="_top">
                            <i class="fas fa-dollar-sign nav-icon"></i> Tarif Pembayaran
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master-payment/discount" target="_top">
                            <i class="fas fa-percentage nav-icon"></i> Potongan Pembayaran
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master-payment/account-bank" target="_top">
                            <i class="fas fa-building nav-icon"></i> Rekening Kas
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-divider"></li>
            <li class="nav-group">
                <span class="nav-link nav-group-toggle">
                    <i class="fas fa-graduation-cap nav-icon"></i> Pembayaran Siswa
                </span>
                <ul class="nav-group-items">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/student-payment/balance" target="_top">
                            <i class="fas fa-piggy-bank nav-icon"></i> Deposit
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/student-payment/bill" target="_top">
                            <i class="fas fa-dollar-sign nav-icon"></i> Pembayaran Tagihan
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-divider"></li>
            <li class="nav-title">Akademik</li>
            <li class="nav-item">
                <router-link class="nav-link" to="/app/admin/master-user">
                    <i class="fas fa-user nav-icon"></i> Data Pengguna
                </router-link>
            </li>
            <li class="nav-group">
                <span class="nav-link nav-group-toggle">
                    <i class="fas fa-mask nav-icon"></i> Master
                </span>
                <ul class="nav-group-items">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master/school-year" target="_top">
                            <i class="fas fa-calendar-times nav-icon"></i> Tahun Ajaran
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/app/admin/master/grade" target="_top">
                            <i class="fas fa-university nav-icon"></i> Jenjang
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-divider"></li>
            <li class="nav-title">Administrator</li>
            <li class="nav-item">
                <router-link class="nav-link" to="/app/admin/user">
                    <i class="fas fa-user-secret nav-icon"></i> Pengguna Portal
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/app/admin/role">
                    <i class="fas fa-user-md nav-icon"></i> Jabatan
                </router-link>
            </li>
        </ul>
        <!--<button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>-->
    </div>
</template>