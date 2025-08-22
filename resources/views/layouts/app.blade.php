<!DOCTYPE html>

<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recruit CRM</title>
    <meta name="description" content="A modern Recruiting CRM for your Business by AdamSon's." />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('fav.png') }}">
    <link rel="icon" href="{{ asset('fav.png') }}" type="image/x-icon">

    <!-- Daterangepicker CSS -->
    <link href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

    <!-- Data Table CSS -->
    <link href="{{ asset('vendors/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('vendors/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Select2 CSS -->
    <link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- CSS -->
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">
    {{-- sweetalert --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Tagify CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>


</head>

<body>
    <!-- Wrapper -->
    <div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
        <!-- Top Navbar -->
        <nav class="hk-navbar navbar navbar-expand-xl navbar-light fixed-top">
            <div class="container-fluid">
                <!-- Start Nav -->
                <div class="nav-start-wrap">
                    <button
                        class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle d-xl-none"><span
                            class="icon"><span class="feather-icon"><i
                                    data-feather="align-left"></i></span></span></button>

                    <!-- Search -->
                    <form class="dropdown navbar-search">
                        <div class="dropdown-toggle no-caret" data-bs-toggle="dropdown" data-dropdown-animation
                            data-bs-auto-close="outside">
                            <a href="#"
                                class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover  d-xl-none"><span
                                    class="icon"><span class="feather-icon"><i
                                            data-feather="search"></i></span></span></a>
                            <div class="input-group d-xl-flex d-none">
                                <span class="input-affix-wrapper input-search affix-border">
                                    <input type="text" class="form-control  bg-transparent"
                                        data-navbar-search-close="false" placeholder="Search..." aria-label="Search">
                                    <span class="input-suffix"><span>/</span>
                                        <span class="btn-input-clear"><i class="bi bi-x-circle-fill"></i></span>
                                        <span class="spinner-border spinner-border-sm input-loader text-primary"
                                            role="status">
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="dropdown-menu p-0">
                            <!-- Mobile Search -->
                            <div class="dropdown-item d-xl-none bg-transparent">
                                <div class="input-group mobile-search">
                                    <span class="input-affix-wrapper input-search">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            aria-label="Search">
                                        <span class="input-suffix">
                                            <span class="btn-input-clear"><i class="bi bi-x-circle-fill"></i></span>
                                            <span class="spinner-border spinner-border-sm input-loader text-primary"
                                                role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <!--/ Mobile Search -->
                            <div data-simplebar class="dropdown-body p-2">
                                <h6 class="dropdown-header">Recent Search
                                </h6>
                                <div class="dropdown-item bg-transparent">
                                    <a href="#" class="badge badge-pill badge-soft-secondary">Grunt</a>

                                </div>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Help
                                </h6>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <div class="media align-items-center">
                                        <div class="media-head me-2">
                                            <div class="avatar avatar-icon avatar-xs avatar-soft-light avatar-rounded">
                                                <span class="initial-wrap">
                                                    <span class="svg-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-corner-down-right"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M6 6v6a3 3 0 0 0 3 3h10l-4 -4m0 8l4 -4"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            How to setup theme?
                                        </div>
                                    </div>
                                </a>

                            </div>

                        </div>
                    </form>
                    <!-- /Search -->
                </div>
                <!-- /Start Nav -->

                <!-- End Nav -->
                <div class="nav-end-wrap">
                    <ul class="navbar-nav flex-row">

                        <li class="nav-item">
                            <div class="dropdown dropdown-notifications">
                                <a href="#"
                                    class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover dropdown-toggle no-caret"
                                    data-bs-toggle="dropdown" data-dropdown-animation role="button"
                                    aria-haspopup="true" aria-expanded="false"><span class="icon"><span
                                            class="position-relative"><span class="feather-icon"><i
                                                    data-feather="bell"></i></span><span
                                                class="badge badge-success badge-indicator position-top-end-overflow-1"></span></span></span></a>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <h6 class="dropdown-header px-4 fs-6">Notifications<a href="#"
                                            class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"><span
                                                class="icon"><span class="feather-icon"><i
                                                        data-feather="settings"></i></span></span></a>
                                    </h6>
                                    <div data-simplebar class="dropdown-body  p-2">
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            <div class="media">
                                                <div class="media-head">
                                                    <div class="avatar avatar-rounded avatar-sm">

                                                        <img src="dist/img/avatar2.jpg" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <div class="notifications-text">Morgan Freeman accepted your
                                                            invitation to join the team</div>
                                                        <div class="notifications-info">
                                                            <span class="badge badge-soft-success">Collaboration</span>
                                                            <div class="notifications-time">Today, 10:14 PM</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="dropdown-footer"><a href="#"><u>View all notifications</u></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown ps-2">
                                <a class=" dropdown-toggle no-caret" href="#" role="button"
                                    data-bs-display="static" data-bs-toggle="dropdown" data-dropdown-animation
                                    data-bs-auto-close="outside" aria-expanded="false">
                                    <div class="avatar avatar-rounded avatar-xs">
                                        @php
                                            $nameParts = explode(' ', Auth::user()->name);
                                            $firstInitial = substr($nameParts[0], 0, 1);
                                            $lastInitial = substr(end($nameParts), 0, 1);
                                            $initials = strtoupper($firstInitial . $lastInitial);
                                        @endphp
                                        <span class="initial-wrap"
                                            style="background-color: lightblue;">{{ $initials }}</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="p-2">
                                        <div class="media">
                                            <div class="media-head me-2">
                                                @php
                                                    $nameParts = explode(' ', Auth::user()->name);
                                                    $firstInitial = substr($nameParts[0], 0, 1);
                                                    $lastInitial = substr(end($nameParts), 0, 1);
                                                    $initials = strtoupper($firstInitial . $lastInitial);
                                                @endphp

                                                <div class="avatar avatar-primary avatar-xs avatar-rounded">
                                                    <span class="initial-wrap">{{ $initials }}</span>
                                                </div>

                                            </div>
                                            <div class="media-body">
                                                <div class="">
                                                    <a href="#" class="d-block link-dark fw-medium"
                                                        data-bs-toggle="dropdown" data-dropdown-animation
                                                        data-bs-auto-close="inside">{{ Auth::user()->name }}</a>

                                                </div>
                                                <div class="fs-7">{{ Auth::user()->email }}</div>
                                                <form method="POST" action="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                    <a href="route('logout" class="d-block fs-8 link-secondary">
                                                        <u>
                                                            @csrf
                                                            Sign Out
                                                        </u>
                                                </form>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                    @if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('Recruiter Company'))
                                        <a class="dropdown-item" href="{{ route('companies.index') }}">Manage Company
                                            Details</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('term.conditions') }}">Terms &
                                        Conditions</a>
                                    <a class="dropdown-item" href="#">Help & Support</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /End Nav -->
            </div>
        </nav>
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <div class="hk-menu">
            <!-- Brand -->
            <div class="menu-header">
                <span>
                    <a class="navbar-brand" href="index.html">
                        <img class="brand-img img-fluid mb-2" src="{{ asset('logo.png') }}" width="50px"
                            alt="brand" />
                        <label for=""
                            style="margin-top:2%;margin-left: 5%;font-weight: 999;font-size:20px">Recruitment
                            CRM</label>
                        <!-- <img class="brand-img img-fluid" src="dist/img/Jampack.svg" alt="brand" /> -->
                    </a>
                    <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
                        <span class="icon">
                            <span class="svg-icon fs-5">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="10" y1="12" x2="20" y2="12"></line>
                                    <line x1="10" y1="12" x2="14" y2="16"></line>
                                    <line x1="10" y1="12" x2="14" y2="8"></line>
                                    <line x1="4" y1="4" x2="4" y2="20"></line>
                                </svg>
                            </span>
                        </span>
                    </button>
                </span>
            </div>
            <!-- /Brand -->

            <!-- Main Menu -->
            <div data-simplebar class="nicescroll-bar">
                <div class="menu-content-wrap">
                    <div class="menu-group">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-template" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="4" y="4" width="16" height="4" rx="1" />
                                                <rect x="4" y="12" width="6" height="8" rx="1" />
                                                <line x1="14" y1="12" x2="20" y2="12" />
                                                <line x1="14" y1="16" x2="20" y2="16" />
                                                <line x1="14" y1="20" x2="20" y2="20" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Dashboard</span>
                                    <!-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> -->
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="menu-gap"></div>
                    <div class="menu-group">
                        <div class="nav-header">
                            <span>Apps</span>
                        </div>
                        <ul class="navbar-nav flex-column">

                            <li class="nav-item">
                                @role('super-admin')
                                    <a class="nav-link" href="{{ route('admin.companies.manage') }}">
                                        <span class="nav-icon-wrap">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar-time" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                                    <circle cx="18" cy="18" r="4" />
                                                    <path d="M15 3v4" />
                                                    <path d="M7 3v4" />
                                                    <path d="M3 11h16" />
                                                    <path d="M18 16.496v1.504l1 1" />
                                                </svg>
                                            </span>
                                        </span>



                                        <span class="nav-link-text">Recruiter Companies</span>


                                    </a>
                                @endrole
                                @role('super-admin')
                                    <a class="nav-link" href="{{ route('roles.index') }}">
                                        <span class="nav-icon-wrap">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar-time" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                                    <circle cx="18" cy="18" r="4" />
                                                    <path d="M15 3v4" />
                                                    <path d="M7 3v4" />
                                                    <path d="M3 11h16" />
                                                    <path d="M18 16.496v1.504l1 1" />
                                                </svg>
                                            </span>
                                        </span>



                                        <span class="nav-link-text">Roles</span>


                                    </a>
                                @endrole

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('jobs.index') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-inbox" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                                <path d="M4 13h3l3 3h4l3 -3h3" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Jobs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#dash_scrumboard">
                                    <span class="nav-icon-wrap position-relative">
                                        {{-- <span
                                            class="badge badge-sm badge-primary badge-sm badge-pill position-top-end-overflow">3</span> --}}
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-layout-kanban" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="4" y1="4" x2="10" y2="4" />
                                                <line x1="14" y1="4" x2="20" y2="4" />
                                                <rect x="4" y="8" width="6" height="12" rx="2" />
                                                <rect x="14" y="8" width="6" height="6" rx="2" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Candidates</span>
                                </a>
                                <ul id="dash_scrumboard" class="nav flex-column collapse  nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('resume.index') }}"><span
                                                        class="nav-link-text">CV Parsing</span></a>
                                            </li>

                                            {{-- <li class="nav-item">
                                                <a class="nav-link" href="{{ route('resume.list') }}"><span
                                                        class="nav-link-text">Manage Candidates List</span></a>
                                            </li> --}}

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact.index') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-notebook" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                                                <line x1="13" y1="8" x2="15" y2="8" />
                                                <line x1="13" y1="12" x2="15" y2="12" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Contact</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="menu-gap"></div>


                </div>
            </div>
            <!-- /Main Menu -->
        </div>
        <div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
        <!-- /Vertical Nav -->

        <!-- Chat Popup -->
        <div class="hk-chatbot-popup">
            <header>
                <div class="chatbot-head-top">
                    <a class="btn btn-sm btn-icon btn-dark btn-rounded" href="javascript:void(0);"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon"><span class="feather-icon"><i
                                    data-feather="more-horizontal"></i></span></span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i
                                class="dropdown-icon zmdi zmdi-notifications-active"></i><span>Send push
                                notifications</span></a>
                        <a class="dropdown-item" href="#"><i
                                class="dropdown-icon zmdi zmdi-volume-off"></i><span>Mute
                                Chat</span></a>
                    </div>
                    <span class="text-white">Chat with Us</span>
                    <a id="minimize_chatbot" href="javascript:void(0);"
                        class="btn btn-sm btn-icon btn-dark btn-rounded">
                        <span class="icon"><span class="feather-icon"><i data-feather="minus"></i></span></span>
                    </a>
                </div>
                <div class="separator-full separator-light mt-0 opacity-10"></div>
                <div class="media-wrap">
                    <div class="media">
                        <div class="media-head">
                            <div
                                class="avatar avatar-sm avatar-soft-primary avatar-icon avatar-rounded position-relative">
                                <span class="initial-wrap">
                                    <i class="ri-customer-service-2-line"></i>
                                </span>
                                <span
                                    class="badge badge-success badge-indicator badge-indicator-lg badge-indicator-nobdr position-bottom-end-overflow-1"></span>
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="user-name">Chat Robot</div>
                            <div class="user-status">Online</div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="chatbot-popup-body">
                <div data-simplebar class="nicescroll-bar">
                    <div>
                        <div class="init-content-wrap">
                            <div class="card card-shadow">
                                <div class="card-body">
                                    <p class="card-text">Hey I am chat robot 😈<br>Do yo have any question regarding
                                        our
                                        tools?<br><br>Select the topic or start chatting.</p>
                                    <button class="btn btn-block btn-primary text-nonecase start-conversation">Start a
                                        conversation</button>
                                </div>
                            </div>
                            <div class="btn-wrap">
                                <button
                                    class="btn btn-soft-primary text-nonecase btn-rounded start-conversation"><span><span
                                            class="icon"><span class="feather-icon"><i
                                                    data-feather="eye"></i></span></span><span class="btn-text">Just
                                            browsing</span></span></button>
                                <button class="btn btn-soft-danger text-nonecase btn-rounded start-conversation"><span><span
                                            class="icon"><span class="feather-icon"><i
                                                    data-feather="credit-card"></i></span></span><span
                                            class="btn-text">I have a question regarding pricing</span></span></button>
                                <button
                                    class="btn btn-soft-warning text-nonecase btn-rounded start-conversation"><span><span
                                            class="icon"><span class="feather-icon"><i
                                                    data-feather="cpu"></i></span></span><span class="btn-text">Need
                                            help for technical query</span></span></button>
                                <button
                                    class="btn btn-soft-success text-nonecase btn-rounded start-conversation"><span><span
                                            class="icon"><span class="feather-icon"><i
                                                    data-feather="zap"></i></span></span><span class="btn-text">I have
                                            a
                                            pre purchase question</span></span></button>
                            </div>
                        </div>
                        <ul class="list-unstyled d-none">
                            <li class="media sent">
                                <div class="media-body">
                                    <div class="msg-box">
                                        <div>
                                            <p>I have a plan regarding pricing</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="media received">
                                <div class="avatar avatar-xs avatar-soft-primary avatar-icon avatar-rounded">
                                    <span class="initial-wrap">
                                        <i class="ri-customer-service-2-line"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <div class="msg-box">
                                        <div>
                                            <p>Welcome back!<br>Are you looking to upgrade your existing plan?</p>
                                        </div>
                                    </div>
                                    <div class="msg-box typing-wrap">
                                        <div>
                                            <div class="typing">
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <footer>
                <div class="chatbot-intro-text fs-7">
                    <div class="separator-full separator-light"></div>
                    <p class="mb-2">This is Adamson's beta version please sign up now to get early access to our
                        full
                        version</p>
                    <a class="d-block mb-2" href="#"><u>Give Feedback</u></a>
                </div>
                <div class="input-group d-none">
                    <div class="input-group-text overflow-show border-0">
                        <button
                            class="btn btn-icon btn-flush-dark flush-soft-hover btn-rounded dropdown-toggle no-caret"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon"><span class="feather-icon"><i
                                        data-feather="share"></i></span></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-icon avatar-xs avatar-soft-primary avatar-rounded me-3">
                                        <span class="initial-wrap">
                                            <i class="ri-image-line"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0">Photo or Video Library</span>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-icon avatar-xs avatar-soft-info avatar-rounded me-3">
                                        <span class="initial-wrap">
                                            <i class="ri-file-4-line"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0">Documents</span>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-icon avatar-xs avatar-soft-success avatar-rounded me-3">
                                        <span class="initial-wrap">
                                            <i class="ri-map-pin-line"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0">Location</span>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-icon avatar-xs avatar-soft-blue avatar-rounded me-3">
                                        <span class="initial-wrap">
                                            <i class="ri-contacts-line"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="h6 mb-0">Contact</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <input type="text" id="input_msg_chat_popup" name="send-msg"
                        class="input-msg-send form-control border-0 shadow-none" placeholder="Type something...">
                    <div class="input-group-text overflow-show border-0">
                        <button class="btn btn-icon btn-flush-dark flush-soft-hover btn-rounded">
                            <span class="icon"><span class="feather-icon"><i
                                        data-feather="smile"></i></span></span>
                        </button>
                    </div>
                </div>
                <div class="footer-copy-text">Powered by <a class="brand-link" href="#"><img
                            src="dist/img/logo-light.png" alt="logo-brand"></a></div>
            </footer>
        </div>
        <a href="#" class="btn btn-icon btn-floating btn-primary btn-lg btn-rounded btn-popup-open">
            <span class="icon">
                <span class="feather-icon"><i data-feather="message-circle"></i></span>
            </span>
        </a>
        <!-- <div class="chat-popover shadow-xl">
            <p>Try Adomson's Chat for free and connect with your customers now!</p>
        </div> -->
        <!-- /Chat Popup -->

        <!-- Main Content -->
        <div class="hk-pg-wrapper">

            @yield('content')

            <!-- Page Footer -->
            <div class="hk-footer">
                <footer class="container-xxl footer">
                    <div class="row">
                        <div class="col-xl-8">
                            <p class="footer-text"><span class="copy-text">Adamson's © 2023 All rights
                                    reserved.</span>
                                <a href="#" class="" target="_blank">Privacy Policy</a><span
                                    class="footer-link-sep">|</span><a href="#" class=""
                                    target="_blank">T&C</a><span class="footer-link-sep">|</span><a href="#"
                                    class="" target="_blank">System
                                    Status</a>
                            </p>
                        </div>
                        <div class="col-xl-4">
                            <a href="#" class="footer-extr-link link-default"><span class="feather-icon"><i
                                        data-feather="external-link"></i></span><u>Send feedback to our help
                                    forum</u></a>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- / Page Footer -->

        </div>
        <!-- /Main Content -->
    </div>
    <!-- /Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- FeatherIcons JS -->
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('vendors/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Data Table JS -->
    <script src="{{ asset('vendors/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Daterangepicker JS -->
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('dist/js/daterangepicker-data.js') }}"></script>

    <!-- Amcharts Maps JS -->
    <script src="https://cdn.amcharts.com/lib/5/index.js')}}"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js')}}"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js')}}"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js')}}"></script>

    <!-- Apex JS -->
    <script src="{{ asset('vendors/apexcharts/dist/apexcharts.min.js') }}"></script>

    <!-- Init JS -->
    <script src="{{ asset('dist/js/init.js') }}"></script>
    <script src="{{ asset('dist/js/chips-init.js') }}"></script>
    <script src="{{ asset('dist/js/dashboard-data.js') }}"></script>

    <!-- Tinymce JS -->
    <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('dist/js/tinymce-data.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('vendors/select2/dist/js/select2.full.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $(".select2").select2();
        });
    </script>


</body>

</html>
