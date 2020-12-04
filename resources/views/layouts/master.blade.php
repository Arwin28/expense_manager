<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Expense Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <!-- Font Awesome Icons -->--}}
{{--    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">--}}
{{--    <!-- Theme style -->--}}
{{--    <link rel="stylesheet" href="dist/css/adminlte.min.css">--}}
{{--    <!-- Google Font: Source Sans Pro -->--}}
{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">--}}

    <link rel="stylesheet" href="/css/app.css">
        <style>
            a.nav-link {
                color: #ffffff;
            }

            nav.navbar.navbar-inverse {
                background: linear-gradient(to right, #007bff, #0E0E70);
                color: black;
            }

            .brand-link .brand-image {
                float: none !important;
            }

            aside.main-sidebar.sidebar-dark-primary.elevation-4 {
                background-color: #0E0E70;
            }
        </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
    <li>

<a class="nav-link" href="{{ route('logout') }}"
   onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
    <i class="nav-icon fas fa-power-off red"></i> {{ __('LOGOUT') }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</li>
    </ul>
  </div>
</nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <center>
        <a href="index3.html" class="brand-link">
       
            <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image  elevation-3"><br>
            <span class="brand-text font-weight-light">Expense Manager</span>
            
        </a>
        <input type="hidden" value="{{$img =Auth::user()->photo }}">
        </center>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset("/img/profile/{$img}")}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">  {{ Auth::user()->name }} </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <router-link to="/Dashbord" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt blue"></i>
                            <p>
                                Dashbord

                            </p>
                        </router-link>
                    </li>
                    @can('isAdmin')
                    <li class="nav-item has-treeview ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-users-cog green"></i>
                            <p>
                                Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/Users" class="nav-link ">
                                    <i class="fas fa-users nav-icon sunflower"></i>
                                    <p>Users</p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/Category" class="nav-link ">
                                    <i class="fas fa-list nav-icon sunflower"></i>
                                    <p>Expense Category</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    @endcan

                    <li class="nav-item">
                        <router-link to="/Expense" class="nav-link">
                            <i class="nav-icon fas fa-credit-card "></i>
                            <p>
                                Expense
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/Profile" class="nav-link">
                            <i class="nav-icon fas fa-user "></i>
                            <p>
                                Profile

                            </p>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>
                <!-- set progressbar -->
                <vue-progress-bar></vue-progress-bar>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
         
        </div>
        <!-- Default to the left -->
        <strong>Expense Manager by ARB Call Facilities</strong> .
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

{{--<!-- jQuery -->--}}
{{--<script src="plugins/jquery/jquery.min.js"></script>--}}
{{--<!-- Bootstrap 4 -->--}}
{{--<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>--}}
{{--<!-- AdminLTE App -->--}}
{{--<script src="dist/js/adminlte.min.js"></script>--}}

@auth
    <script>
        window.user =  @json(auth()->user())
    </script>
@endauth
<script src="/js/app.js"></script>

</body>
</html>
