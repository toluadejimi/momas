<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8"/>
    <title>Dashboard | Momaspay Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Momas Admin"/>
    <meta name="author" content="Momaspay"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('')}}/public/assets/ass/images/favicon.ico">

    <!-- App css -->
    <link href="{{url('')}}/public/assets/ass/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>

    <!-- Icons -->
    <link href="{{url('')}}/public/assets/ass/css/icons.min.css" rel="stylesheet" type="text/css"/>

</head>

<!-- body start -->
<body data-menu-color="light" data-sidebar="default"

<!-- Begin page -->
<div id="app-layout">


    <!-- Topbar Start -->
    <div class="topbar-custom">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li>
                        <button class="button-toggle-menu nav-link">
                            <i data-feather="menu" class="noti-icon"></i>
                        </button>
                    </li>
                    <li class="d-none d-lg-block">
                        <h5 class="mb-0">Good Morning, Admin</h5>
                    </li>
                </ul>

                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">


                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown"
                           href="analytics.html#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{url('')}}/public/assets/ass/images/users/user-5.jpg" alt="user-image"
                                 class="rounded-circle">
                            <span class="pro-user-name ms-1">
                                        Admin <i class="mdi mdi-chevron-down"></i>
                                    </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a class='dropdown-item notify-item' href='/logout'>
                                <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                <span>Logout</span>
                            </a>



                        </div>
                    </li>

                </ul>
            </div>

        </div>

    </div>
    <!-- end Topbar -->

    <!-- Left Sidebar Start -->
    <div class="app-sidebar-menu">
        <div class="h-100" data-simplebar>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <div class="logo-box">
                    <a class='logo logo-light' href='index.html'>
                                <span class="logo-sm">
                                    <img src="{{url('')}}/public/assets/ass/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{url('')}}/public/assets/ass/images/logo-light.png" alt="" height="24">
                                </span>
                    </a>
                    <a class='logo logo-dark' href='index.html'>
                                <span class="logo-sm">
                                    <img src="{{url('')}}/public/assets/ass/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="{{url('')}}/public/assets/ass/images/logo-dark.png" alt="" height="24">
                                </span>
                    </a>
                </div>

                @if(auth::user()->role == 0)
                    <ul id="side-menu">

                        <li class="menu-title">Menu</li>

                        <li>
                            <a class='tp-link'  href="admin-dashboard">
                                <i data-feather="menu"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="customers">
                                <i data-feather="users"></i>
                                <span> Customers </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="meter-list">
                                <i data-feather="cpu"></i>
                                <span> Meter </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="asset">
                                <i data-feather="archive"></i>
                                <span> Assets </span>
                            </a>
                        </li>

                        <li>
                            <a class='tp-link'  href="organization">
                                <i data-feather="folder"></i>
                                <span> Organization </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="transformer-list">
                                <i data-feather="box"></i>
                                <span> Transformer </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="estate">
                                <i data-feather="home"></i>
                                <span> Estate </span>
                            </a>
                        </li>




                        <li>
                            <a class='tp-link'  href="tariff-list">
                                <i data-feather="divide-square"></i>
                                <span> Tariff </span>
                            </a>
                        </li>



                        <li>
                            <a class='tp-link'  href="users-list">
                                <i data-feather="users"></i>
                                <span> Users </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="settings">
                                <i data-feather="settings"></i>
                                <span> Settings </span>
                            </a>
                        </li>





                    </ul>
                @elseif(auth::user()->role == 1)
                @elseif(auth::user()->role == 2)
                @elseif(auth::user()->role == 3)
                    <ul id="side-menu">

                        <li class="menu-title">Menu</li>

                        <li>
                            <a class='tp-link'  href="admin-dashboard">
                                <i data-feather="menu"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="customers">
                                <i data-feather="users"></i>
                                <span> Customers </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="meter-list">
                                <i data-feather="cpu"></i>
                                <span> Meter </span>
                            </a>
                        </li>




                        <li>
                            <a class='tp-link'  href="transformer-list">
                                <i data-feather="box"></i>
                                <span> Transformer </span>
                            </a>
                        </li>




                        <li>
                            <a class='tp-link'  href="tariff-list">
                                <i data-feather="divide-square"></i>
                                <span> Tariff </span>
                            </a>
                        </li>



                        <li>
                            <a class='tp-link'  href="users-list">
                                <i data-feather="users"></i>
                                <span> Users </span>
                            </a>
                        </li>


                        <li>
                            <a class='tp-link'  href="settings">
                                <i data-feather="settings"></i>
                                <span> Settings </span>
                            </a>
                        </li>


                    </ul>
                @elseif(auth::user()->role == 4)
                @elseif(auth::user()->role == 5)
                @else
                @endif





            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

        @yield('content')

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col fs-13 text-muted text-center">
                        &copy;
                        <script>document.write(new Date().getFullYear())</script>
                        - MOMASPAY
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor -->
<script src="{{url('')}}/public/assets/ass/libs/jquery/jquery.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/simplebar/simplebar.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/node-waves/waves.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/jquery.counterup/jquery.counterup.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/feather-icons/feather.min.js"></script>

<!-- Apexcharts JS -->
<script src="{{url('')}}/public/assets/ass/libs/apexcharts/apexcharts.min.js"></script>

<!-- for basic area chart -->
<script src="{{url('')}}/public/assets/ass/stock-prices.js"></script>

<!-- Widgets Init Js -->
<script src="{{url('')}}/public/assets/ass/js/pages/analytics-dashboard.init.js"></script>

<!-- App js-->
<script src="{{url('')}}/public/assets/ass/js/app.js"></script>


<!-- Datatables js -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net/js/jquery.dataTables.min.js"></script>

<!-- dataTables.bootstrap5 -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

<!-- buttons.colVis -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-buttons/js/buttons.print.min.js"></script>

<!-- buttons.bootstrap5 -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>

<!-- dataTables.keyTable -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>

<!-- dataTable.responsive -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

<!-- dataTables.select -->
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{url('')}}/public/assets/ass/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

<!-- Datatable Demo App Js -->
<script src="{{url('')}}/public/assets/ass/js/pages/datatable.init.js"></script>

</body>
</html>
