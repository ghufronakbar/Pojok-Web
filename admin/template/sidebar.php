<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .sb-sidenav {
            background-color: mediumaquamarine !important;
        }

        .sb-sidenav .nav-link,
        .sb-sidenav .nav-link .sb-nav-link-icon {
            color: black !important;
        }

        .sb-sidenav .nav-link:hover,
        .sb-sidenav .nav-link:hover .sb-nav-link-icon {
            color: black !important;
        }
    </style>
    <!-- Link untuk Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="pelanggan.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Pelanggan
                    </a>
                    <a class="nav-link" href="transaksi.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake"></i></div>
                        Transaksi
                    </a>
                    <a class="nav-link" href="layanan.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                        Layanan
                    </a>
                    <a class="nav-link" href="laporan.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-book-skull"></i></div>
                        Laporan
                    </a>
                </div>
            </div>
        </nav>
    </div>
</body>
</html>