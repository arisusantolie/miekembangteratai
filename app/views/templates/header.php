<?php
if (!isset($_SESSION["login"])) {
    header("Location:" . BASEURL . "/adminlogin");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mie Kembang Teratai</title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom fonts for this template-->
    <link href="<?= BASEURL ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= BASEURL ?>/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= BASEURL ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- my css -->
    <link rel="stylesheet" href="<?= BASEURL ?>/css/styles.css">

    <!-- search select picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />



</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASEURL ?>/index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">KEMBANG TERATAI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Adminhome/index">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - produk -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Listpesanan">
                    <i class="fas fa-list-alt"></i>
                    <span>List Pesanan</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Listutang">
                    <i class="fas fa-list"></i>
                    <span>List Utang</span></a>
            </li>

            <!-- Nav Item - produk -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Produk">
                    <i class=" fab fa-product-hunt"></i>
                    <span>Produk</span></a>
            </li>


            <!-- Nav Item - bahan -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Bahan">
                    <i class="fas fa-book"></i>
                    <span>Bahan</span></a>
            </li>

            <!-- Nav Item - Pembelian Bahan -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Pembelian">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pembelian Bahan</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/PembelianProduk">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pembelian Produk</span></a>
            </li>

            <!-- Nav Item - Suppliers -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Supplier">
                    <i class="fas fa-user-friends"></i>
                    <span>Suppliers</span></a>
            </li>

            <!-- Nav Item - Customers -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Customer">
                    <i class="fas fa-users"></i>
                    <span>Customers</span></a>
            </li>

            <!-- Nav Item - Produksi -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Produksi">
                    <i class="fas fa-blender"></i>
                    <span>Produksi</span></a>
            </li>

            <!-- Nav Item - Penjualan -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASEURL ?>/Penjualan">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Penjualan Produk</span></a>
            </li>



            <!-- Nav Item - Reporting -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-line"></i>
                    <span>Laporan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">






                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Fandri Lie</span>
                                <img class="img-profile rounded-circle" src="https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-1/p160x160/42306203_10209665433430902_6542140394820337664_n.jpg?_nc_cat=100&_nc_oc=AQlow0agEkHKLjQTiDp32iJIqHYaRYn5tCyWDaoeUisoPAuaDhNeqw63jctz4XWQIqw&_nc_ht=scontent-sin6-1.xx&oh=231c7079b8400ff9f3d8c9249f1eb84f&oe=5E63EBEB">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->