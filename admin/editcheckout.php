<?php
ob_start(); // Mulai output buffering
include 'template/header.php';
?>
<?php
// Ambil checkout_id dari URL
$checkout_id = $_GET['checkout_id'];

// Ambil data checkout dari database berdasarkan checkout_id
$ambil_checkout = $conn->query("
    SELECT c.checkout_id, c.checkout_status, p.pelanggan_nama, p.pelanggan_alamat, c.checkout_waktu, pembayaran.pembayaran_jumlahbayar, kr.keranjang_id from checkout c left join keranjang kr on c.keranjang_id = kr.keranjang_id left join pelanggan p on kr.pelanggan_id = p.pelanggan_id left join pembayaran on c.checkout_id = pembayaran.checkout_id WHERE c.checkout_id = '$checkout_id'
");

$checkout = $ambil_checkout->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan'])) {
    // Ambil data dari form
    $status_baru = $_POST['status'];

    // Update status checkout di database
    $conn->query("
        UPDATE checkout
        SET checkout_status = '$status_baru'
        WHERE checkout_id = '$checkout_id'
    ");

    // Redirect ke halaman transaksi setelah update
    header("Location: transaksi.php");
    exit();
}
?>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-red">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3">Pojok Shoescare</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <?php include 'template/sidebar.php' ?>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Checkout</h1>
            <div class="card col-xl-6 mb-4">
                <div class="card-header">
                    Edit Checkout
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" value="<?php echo $checkout['pelanggan_nama']; ?>"
                                disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" class="form-control" value="<?php echo $checkout['pembayaran_jumlahbayar']; ?>"
                                disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Status Transaksi</label>
                            <select name="status" class="form-control">
                                <option value="dipesan" <?php if ($checkout["checkout_status"] == 'dipesan')
                                    echo 'selected'; ?>>Dipesan</option>
                                <option value="dijemput" <?php if ($checkout["checkout_status"] == 'dibayar')
                                    echo 'selected'; ?>>Dijemput</option>
                                <option value="diproses" <?php if ($checkout["checkout_status"] == 'masak')
                                    echo 'selected'; ?>>Diproses</option>
                                <option value="selesai" <?php if ($checkout["checkout_status"] == 'selesai')
                                    echo 'selected'; ?>>Selesai</option>
                            </select>
                        </div>
                        <button name="simpan" class="btn btn-primary">Submit</button>
                        <a href="transaksi.php" class="btn btn-danger text-white">Batal</a>
                    </form>
                </div>
            </div>
        </div>
        </main>
        <?php
        include 'template/footer.php';
        ob_end_flush(); // Akhiri output buffering dan kirim output
        ?>