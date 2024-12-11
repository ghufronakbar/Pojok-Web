<?php include 'template/header.php' ?>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Pojok Shoescare</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!"><b>Hallo Admin</b></a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
        <?php include 'template/sidebar.php' ?>
        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Ganti Password Pelanggan </h1>
                        <div class="card col-xl-6 mb-4">
                            <div class="card-header">
                                Update Password Pelanggan
                            </div>
                            <div class="card-body">
                            <form>
                                <div class="form-group mb-3">
                                    <label for="editNamaPelanggan">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="editNamaPelanggan" placeholder="Masukan Nama">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="editNomorPelanggan">No Handphone</label>
                                    <input type="number" class="form-control" id="editNomorPelanggan" placeholder="Masukan No Handphone">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="editAlamatPelanggan">Alamat</label>
                                    <input type="text" class="form-control" id="editAlamatPelanggan" placeholder="Masukan Alamat">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="editAlamatPelanggan"> Password</label>
                                    <input type="password" class="form-control" id="editAlamatPelanggan" placeholder="Masukan Password Baru">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a class="btn btn-danger text-white">Batal</a>
                            </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            </div>
            <?php include 'template/footer.php'?>