<?php
session_start();
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Farm Rental System</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="../assets/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/node_modules/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="../assets/node_modules/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/node_modules/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet"
        href="../assets/node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../assets/node_modules/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" href="../assets/node_modules/c3/c3.min.css">
    <link rel="stylesheet" href="../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/node_modules/owl.carousel/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="../assets/node_modules/owl.carousel/dist/assets/owl.theme.default.css">
    <link rel="stylesheet" href="../assets/dist/css/theme.min.css">
    <script src="../assets/src/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
    .table {
        margin-top: 20px;
        border-radius: 5px;
        overflow: hidden;
        font-size: 13px;
    }

    .table th,
    .table td {
        text-align: justify;
        vertical-align: middle;
        font-size: 13px;
        font-family: Georgia, 'Times New Roman', Times, serif;
        /* Font size for table headings and data */
    }

    .table th {
        background-color: #2F4F4F;
        color: #ecf0f1;

    }

    .table tbody tr:nth-child(odd) {
        background-color: #ecf0f1;
    }

    .table tbody tr:nth-child(even) {
        background-color: #bdc3c7;
    }

    .btn {
        width: 60px;
        height: 40px;
        border-radius: 20px;
        padding: 0;
        margin: 0 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn i {
        font-size: 18px;
    }
    </style>
</head>

<body>

    <div class="wrapper">
        <header class="header-top" header-theme="light">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div class="top-menu d-flex align-items-center">
                        <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                        <button type="button" id="navbar-fullscreen" class="nav-link"><i
                                class="ik ik-maximize"></i></button>
                    </div>
                    <div class="top-menu d-flex align-items-center">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="ik ik-user dropdown-icon"></i></a>
                            <b style="font-size: 17px; font-family:Georgia, 'Times New Roman', Times, serif  ">
                                <?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>
                            </b>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../logout.php"><i class="ik ik-power dropdown-icon"></i>
                                    Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
include("../connection/connection.php");
?>