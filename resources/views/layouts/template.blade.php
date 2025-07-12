<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-TzBZ-AB8Hng2jGB_"></script>

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Medical Check Up | Management System</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/dashboard.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/dashboard.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/dashboard.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    @yield('base.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
                <script>
                    var navbarStyle = localStorage.getItem("navbarStyle");
                    if (navbarStyle && navbarStyle !== 'transparent') {
                        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                    }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">

                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span
                                class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div><a class="navbar-brand" href="#">
                        <div class="d-flex align-items-center py-3"><img class="me-2"
                                src="{{ asset('img/pram.png') }}" alt="" width="85" /><span
                                class="font-sans-serif fs-2 text-youtube">MCU</span>
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar pt-2">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <!-- parent pages--><a class="nav-link dropdown-indicator" href="#dashboard"
                                    role="button" data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="dashboard">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fab fa-dashcube"></span></span><span
                                            class="nav-link-text ps-1">Dashboard</span>
                                    </div>
                                </a>
                                <ul class="nav collapse false" id="dashboard">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.home') }}" aria-expanded="false">
                                            <div class="d-flex align-items-center"><span
                                                    class="nav-link-text ps-1">Default</span>
                                            </div>
                                        </a>
                                        <!-- more inner pages-->
                                    </li>

                                </ul>
                            </li>

                            @php
                                $menu = DB::table('z_menu_user')
                                    ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
                                    ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
                                    ->where('z_menu_user.access_code', Auth::user()->access_code)
                                    // ->orderBy('z_menu.id_menu', 'ASC')
                                    ->get()
                                    ->unique('menu_code');
                            @endphp
                            @foreach ($menu as $menus)
                                <li class="nav-item">
                                    <!-- label-->
                                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                        <div class="col-auto navbar-vertical-label">{{ $menus->menu_name }}
                                        </div>
                                        <div class="col ps-0">
                                            <hr class="mb-0 navbar-vertical-divider" />
                                        </div>
                                    </div>
                                    @php
                                        $sub_menu = DB::table('z_menu_user')
                                            ->join(
                                                'z_menu_sub',
                                                'z_menu_sub.menu_sub_code',
                                                '=',
                                                'z_menu_user.menu_sub_code',
                                            )
                                            ->where('z_menu_user.access_code', Auth::user()->access_code)
                                            ->where('z_menu_sub.menu_code', $menus->menu_code)
                                            ->orderBy('z_menu_sub.id_menu_sub', 'ASC')
                                            ->get();
                                    @endphp
                                    @foreach ($sub_menu as $sub_menus)
                                        <a class="nav-link"
                                            href="{{ url($sub_menus->menu_sub_code . '/' . $sub_menus->menu_sub_link) }}"
                                            role="button" aria-expanded="false">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="{{ $sub_menus->menu_sub_icon }}"></span></span><span
                                                    class="nav-link-text ps-1">{{ $sub_menus->menu_sub_name }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                    <!-- parent pages-->


                                </li>
                            @endforeach

                            @if (Auth::user()->access_code == 'master')
                                <li class="nav-item">
                                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                        <div class="col-auto navbar-vertical-label">Master Admin Data
                                        </div>
                                        <div class="col ps-0">
                                            <hr class="mb-0 navbar-vertical-divider" />
                                        </div>
                                    </div>
                                    <a class="nav-link" href="{{ route('master_access') }}" role="button"
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-user-shield"></span></span>
                                            <span class="nav-link-text ps-1">Master Akses</span>
                                        </div>
                                    </a>
                                    <a class="nav-link" href="{{ route('master_user') }}" role="button"
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="far fa-user"></span></span><span
                                                class="nav-link-text ps-1">Master User</span>
                                        </div>
                                    </a>
                                    <a class="nav-link" href="{{ route('master_cabang') }}" role="button"
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-city"></span></span><span
                                                class="nav-link-text ps-1">Master Cabang</span>
                                        </div>
                                    </a>
                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#master_menu" role="button"
                                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fab fa-windows"></span></span><span
                                                class="nav-link-text ps-1">Master Menu</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse true" id="master_menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('master_menu') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Main Menu</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('master_menu_access') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Akses Menu</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </nav>
            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="#">
                        <div class="d-flex align-items-center"><img class="me-2" src="{{ asset('img/pram.png') }}"
                                alt="" width="80" /><span class="font-sans-serif text-youtube">MCU</span>
                        </div>
                    </a>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">
                        <li class="nav-item">
                            <div class="search-box" data-list='{"valueNames":["title"]}'>
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input fuzzy-search" type="search"
                                        placeholder="Search..." aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>

                                </form>
                                <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                                    data-bs-dismiss="search">
                                    <div class="btn-close-falcon" aria-label="Close"></div>
                                </div>
                                <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100">
                                    <div class="scrollbar list py-3" style="max-height: 24rem;">
                                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                                            Recently Browsed</h6>
                                        <a class="dropdown-item fs--1 px-card py-1 hover-primary" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="fas fa-circle me-2 text-300 fs--2"></span>

                                                <div class="fw-normal title">Pages <span
                                                        class="fas fa-chevron-right mx-1 text-500 fs--2"
                                                        data-fa-transform="shrink-2"></span> Dashboard</div>
                                            </div>
                                        </a>

                                        <hr class="bg-200 dark__bg-900" />
                                    </div>
                                    <div class="text-center mt-n3">
                                        <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item">
                            <div class="theme-control-toggle fa-icon-wait px-2">
                                <input class="form-check-input ms-0 theme-control-toggle-input"
                                    id="themeControlToggle" type="checkbox" data-theme-control="theme"
                                    value="dark" />
                                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                    for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Switch to light theme"><span
                                        class="fas fa-sun fs-0 text-danger"></span></label>
                                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                    for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Switch to dark theme"><span
                                        class="fas fa-moon fs-0 text-danger"></span></label>
                            </div>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait"
                                href="#"><span class="fas fa-shopping-cart"
                                    data-fa-transform="shrink-7" style="font-size: 33px;"></span><span
                                    class="notification-indicator-number">1</span></a>

                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator notification-indicator-danger px-0 fa-icon-wait"
                                id="navbarDropdownNotification" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-bell" data-fa-transform="shrink-6"
                                    style="font-size: 33px;"></span></a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                                aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Notifications</h6>
                                            </div>
                                            <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal"
                                                    href="#">Mark all as read</a></div>
                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height:19rem" id="show-notification">

                                    </div>
                                    <div class="card-footer text-center border-top"><a class="card-link d-block"
                                            href="../app/social/notifications.html">View all</a></div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="{{ asset('img/avatar.png') }}"
                                        alt="" />

                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    {{-- <a class="dropdown-item fw-bold text-warning" href="#!"><span
                                            class="fas fa-crown me-1"></span><span>Go Pro</span></a> --}}
                                    <a class="dropdown-item text-youtube text-center">{{ Auth::user()->fullname }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!" id="button-setup-notification"
                                        data-bs-toggle="modal" data-bs-target="#modal-template-sm"><span
                                            class="fas fa-volume-down"></span> Set Notification</a>
                                    <a class="dropdown-item" href="#" id="button-setup-profil"
                                        data-bs-toggle="modal" data-bs-target="#modal-template-xl"><span
                                            class="fas fa-user-cog"></span> Profile &amp;
                                        account</a>
                                    <div class="dropdown-divider"></div>
                                    {{-- <a class="dropdown-item" href="#">Settings</a> --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"><span
                                            class="fab fa-keycdn"></span> Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                @yield('content')



                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">Thank you for creating with Transforma<span
                                    class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2025 &copy;
                                <a href="#">{{ Env('APP_NAME') }}</a>
                                <button class="btn btn-primary" id="liveToastBtn" type="button" hidden></button>
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <img src="{{ asset('img/logo.png') }}" alt="" width="80">
                        </div>
                    </div>
                </footer>
            </div>
            <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog"
                aria-labelledby="authentication-modal-label" aria-hidden="true">
                <div class="modal-dialog mt-6" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                            <div class="position-relative z-index-1 light">
                                <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                                <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>
                            </div>
                            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4 px-5">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-name">Name</label>
                                    <input class="form-control" type="text" autocomplete="on"
                                        id="modal-auth-name" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="modal-auth-email">Email address</label>
                                    <input class="form-control" type="email" autocomplete="on"
                                        id="modal-auth-email" />
                                </div>
                                <div class="row gx-2">
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-password">Password</label>
                                        <input class="form-control" type="password" autocomplete="on"
                                            id="modal-auth-password" />
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="modal-auth-confirm-password">Confirm
                                            Password</label>
                                        <input class="form-control" type="password" autocomplete="on"
                                            id="modal-auth-confirm-password" />
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        id="modal-auth-register-checkbox" />
                                    <label class="form-label" for="modal-auth-register-checkbox">I accept the <a
                                            href="#!">terms </a>and <a href="#!">privacy
                                            policy</a></label>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">Register</button>
                                </div>
                            </form>
                            <div class="position-relative mt-5">
                                <hr class="bg-300" />
                                <div class="divider-content-center">or register with</div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100"
                                        href="#"><span class="fab fa-google-plus-g me-2"
                                            data-fa-transform="grow-8"></span> google</a></div>
                                <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100"
                                        href="#"><span class="fab fa-facebook-square me-2"
                                            data-fa-transform="grow-8"></span> facebook</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
        aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header settings-panel-header bg-danger">
            <div class="z-index-1 py-1 light">
                <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Settings</h5>
                <p class="mb-0 fs--1 text-white opacity-75"> Set your own customized style</p>
            </div>
            <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
            <h5 class="fs-0">Color Scheme</h5>
            <p class="fs--1">Choose the perfect color mode for your app.</p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio"
                            value="light" data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="{{ asset('asset/img/generic/falcon-mode-default.jpg') }}"
                                    alt="" /></span><span class="label-text">Light</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio"
                            value="dark" data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="{{ asset('asset/img/generic/falcon-mode-dark.jpg') }}"
                                    alt="" /></span><span class="label-text"> Dark</span></label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="{{ asset('asset/img/icons/left-arrow-from-left.svg') }}" width="20"
                        alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">RTL Mode</h5>
                        <p class="fs--1 mb-0">Pariatur labore dolorem laboriosam eum at ratione, nesciunt, tenetur
                            fugiat eligendi minima ducimus iusto animi inventore facilis soluta error repellat amet
                            reprehenderit?</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-rtl" type="checkbox"
                        data-theme-control="isRTL" />
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="{{ asset('asset/img/icons/arrows-h.svg') }}" width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">Fluid Layout</h5>
                        <p class="fs--1 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-fluid" type="checkbox"
                        data-theme-control="isFluid" />
                </div>
            </div>
            <hr />
            <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Style</h5>
            <p class="fs--1 mb-0">Switch between styles for your vertical navbar </p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle"
                            value="transparent" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/default.png') }}"
                                alt="" /><span class="label-text"> Transparent</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle"
                            value="inverted" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/inverted.png') }}"
                                alt="" /><span class="label-text"> Inverted</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle"
                            value="card" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/card.png') }}"
                                alt="" /><span class="label-text"> Card</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle"
                            value="vibrant" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/vibrant.png') }}"
                                alt="" /><span class="label-text"> Vibrant</span></label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
        <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
            <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
                <div class="settings-popover"><span class="ripple">
                        <span class="fa-spin position-absolute all-0 d-flex flex-center">
                            <span class="icon-spin position-absolute all-0 d-flex flex-center">
                                <span class="fas fa-cog text-danger"></span>
                            </span>
                        </span>
                    </span>
                </div>
            </div>
            <small
                class="text-uppercase text-danger fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">Setting</small>
        </div>
    </a>

    {{-- START MODAL --}}
    <div class="modal fade" id="modal-template" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-template-xl" data-bs-keyboard="false" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template-xl"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-template-sm" data-bs-keyboard="false" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template-sm"></div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="{{ asset('online/resumable.min.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>
    @yield('base.js')


    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
            <div class="toast show" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
                data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":3}' data-autohide="false">
                <div class="toast-header bg-primary text-white"><strong class="me-auto">Notice</strong><small>1 sec
                        ago</small>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        </div>
    @elseif (session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
            <div class="toast show" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
                data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":720}' data-autohide="false">
                <div class="toast-header bg-danger text-white"><strong class="me-auto">Notice</strong><small>1 sec
                        ago</small>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        </div>
    @endif


    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
        <div class="toast fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
            data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":720}' data-autohide="false">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">Notice</strong><small>1 sec
                    ago</small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">Data Error</div>
        </div>
    </div>


    @if (Auth::user()->access_status == 0)
        <script>
            window.location.replace("{{ route('logout') }}");
        </script>
    @endif
</body>

</html>
