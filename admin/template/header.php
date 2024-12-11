<?php
include "../conection.php";
if (!isset($_SESSION["admin"]))
{
    echo "<script>alert('Anda harus login !')</script>";
    echo "<script>location = '../index.php'</script>";
}

//mengambil data dari user/admin yang login
$admin_id = $_SESSION["admin"]["admin_id"];
$ambil_admin = $conn -> query("SELECT * FROM admin WHERE admin_id = '$admin_id'");
$admin = $ambil_admin->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Pojok Shoescare</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.5.2/js/all.js" crossorigin="anonymous"></script>
        <style>
            .bg-red {
                background-color: mediumaquamarine !important;
            }
            .navbar, .navbar a, .navbar i {
                color: black !important;
            }
            .sb-sidenav .btn {
                background-color: black;
                color: black;
            }
            .navbar {
                box-shadow: 0 9px 8px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-red">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Pojok Shoescare</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!"><b>Hallo <?php echo $admin['admin_nama']?></b></a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../admin/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
        <?php include 'template/sidebar.php' ?>
            <div id="layoutSidenav_content">
                <main>
