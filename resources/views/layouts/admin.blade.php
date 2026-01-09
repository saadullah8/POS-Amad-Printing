<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/vendor/fonts/circular-std/style.css" rel="stylesheet') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ 'assets/vendor/fonts/fontawesome/css/fontawesome-all.css' }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('../assets/vendor/datatables/css/dataTables.bootstrap4.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../assets/vendor/datatables/css/buttons.bootstrap4.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../assets/vendor/datatables/css/select.bootstrap4.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @yield('style')

    <title>{{ $title }}</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.html">Amad Printing Press</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/avatar-1.jpg') }}" alt=""
                                    class="user-avatar-md rounded-circle border border-white">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 nav-user-name">Super Admin</h5>
                                </div>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    class="dropdown-item text-dark">
                                    <i class="fa fa-sign-out-alt mr-2 text-dark"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->d
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Pos </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
<li class="nav-item">
    <a class="nav-link @if ($active == 'dashboard') active @endif"
       href="{{ url('admin/dashboard/index') }}">
        <i class="fa fa-fw fa-home"></i> Dashboard
    </a>
</li>

                            {{-- for customer --}}
                            <li class="nav-item">
                                <a class="nav-link @if ($active == 'services') active @endif" href="#"
                                    data-toggle="collapse" aria-expanded="false" data-target="#submenu-services"
                                    aria-controls="submenu-services">
                                    <i class="fa fa-fw fa-cogs"></i> Services
                                </a>
                                <div id="submenu-services" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('admin/services/index') }}">View All</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('admin/services/create') }}">Add</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
    <a class="nav-link @if ($active == 'pos') active @endif" href="{{ url('admin/pos/index') }}">
        <i class="fa fa-fw fa-shopping-cart"></i> POS
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @if ($active == 'orders') active @endif" href="#"
        data-toggle="collapse" aria-expanded="false" data-target="#submenu-orders"
        aria-controls="submenu-orders">
        <i class="fa fa-fw fa-receipt"></i> Orders
    </a>
    <div id="submenu-orders" class="collapse submenu">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/orders/index') }}">View All</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/pos/index') }}">New Bill</a></li>
        </ul>
    </div>
</li>

{{-- <li class="nav-item">
    <a class="nav-link @if ($active == 'reports') active @endif" href="#"
        data-toggle="collapse" aria-expanded="false" data-target="#submenu-reports"
        aria-controls="submenu-reports">
        <i class="fa fa-fw fa-chart-bar"></i> Reports
    </a>
    <div id="submenu-reports" class="collapse submenu">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/daily') }}">Daily</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/weekly') }}">Weekly</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/monthly') }}">Monthly</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/yearly') }}">Yearly</a></li>
        </ul>
    </div>
</li> --}}
@if(Auth::user()->role == 1)
<li class="nav-item">
    <a class="nav-link @if ($active == 'reports') active @endif" href="#"
        data-toggle="collapse" aria-expanded="false" data-target="#submenu-reports"
        aria-controls="submenu-reports">
        <i class="fa fa-fw fa-chart-bar"></i> Reports
    </a>
    <div id="submenu-reports" class="collapse submenu">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/daily') }}">Daily</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/weekly') }}">Weekly</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/monthly') }}">Monthly</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reports/yearly') }}">Yearly</a></li>
        </ul>
    </div>
</li>
@endif


                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js -->
    <script src="{{ asset('assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/libs/js/main-js.js') }}"></script>
    <!-- chart chartist js -->
    <script src="{{ asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <!-- sparkline js -->
    <script src="{{ asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- morris js -->
    <script src="{{ asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>
    <!-- chart c3 js -->
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{ asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>



    <script src="{{ asset('../assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('../assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('../assets/vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('../assets/vendor/datatables/js/data-table.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js') }}"></script>



    @yield('script')

</body>

</html>
