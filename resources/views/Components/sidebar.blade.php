<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="/dashboard">
                <img class="img-fluid" src="{{ asset('') }}assets/images/logo/logo_light.png" alt="">
            </a>
            <div class="back-btn">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <svg class="stroke-icon sidebar-toggle status_toggle middle">
                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#toggle-icon"></use>
                </svg>
                <svg class="fill-icon sidebar-toggle status_toggle middle">
                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-toggle-icon"></use>
                </svg>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="/dashboard">
                <img class="img-fluid" src="{{ asset('') }}assets/images/logo/logo-icon.png" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="/dashboard">
                            <img class="img-fluid" src="{{ asset('') }}assets/images/logo/logo-icon.png"
                                alt="">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="/dashboard">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-home"></use>
                            </svg>
                            <span class="">Dashboard </span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Data Akademik</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"> </i>
                        <a class="sidebar-link sidebar-title link-nav" href="/guru">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-project"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-project"></use>
                            </svg>
                            <span>Data Guru </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="/kelas">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-file"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-file"></use>
                            </svg>
                            <span>Data Kelas</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"> </i>
                        <a class="sidebar-link sidebar-title link-nav" href="/siswa">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-board"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-board"></use>
                            </svg>
                            <span>Data Siswa</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="/orangtua">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-ecommerce"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                            </svg>
                            <span>Data Orang Tua</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Aktivitas</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="/jadwal">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-form"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-form"> </use>
                            </svg>
                            <span>Jadwal Pelajaran</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Other</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav"
                            href="/laporan-kehadiran">
                            <svg class="stroke-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-ui-kits"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-ui-kits"></use>
                            </svg>
                            <span>Laporan Kehadiran</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
