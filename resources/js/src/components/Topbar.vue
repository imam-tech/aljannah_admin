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
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg> Lock Account</a><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                        </svg> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>
</template>
