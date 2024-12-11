<?php
// Panggil skrip koneksi yang ada di dalam file koneksi.php
include 'template/header.php';

// Eksekusi kueri SQL untuk menghitung total transaksi selesai
$ambil_total_transaksi_selesai = $conn->query("SELECT COUNT(*) as total_transaksi_selesai FROM checkout WHERE checkout_status = 'selesai'");
$total_transaksi_selesai = $ambil_total_transaksi_selesai->fetch_assoc()['total_transaksi_selesai'];


// Eksekusi kueri SQL untuk menghitung total pelanggan
$ambil_total_pelanggan = $conn->query("SELECT COUNT(*) as total_pelanggan FROM pelanggan");
$total_pelanggan = $ambil_total_pelanggan->fetch_assoc()['total_pelanggan'];


// Total penghasilan keseluruhan
$ambil_pembayaran = $conn->query("SELECT pembayaran_jumlahbayar FROM pembayaran WHERE pembayaran_status = 'success'");
$total = 0;
while ($tiap_pembayaran = $ambil_pembayaran->fetch_assoc()) {
    $total += $tiap_pembayaran['pembayaran_jumlahbayar'];
}
$total_pembayaran = $total;

function formatRupiah($angka) {
    $rupiah = number_format($angka, 0, ',', '.');
    return "Rp ". $rupiah.",00";
}

?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Admin</h1>
    <div class="row">
        <div class="col-xl-6 col-md-6">
        <div class="card bg-success text-white mb-4">
                <div class="card-header">Total Transaksi Selesai</div>
                <div class="card-body"><h3><?php echo $total_transaksi_selesai; ?></h3></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="transaksi.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-header">Total Pelanggan</div>
                <div class="card-body"><h3><?php echo $total_pelanggan; ?></h3></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="pelanggan.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-header text-center">Total Penghasilan Keseluruhan </div>
                <div class="card-body text-center"><h3><?php echo formatRupiah($total_pembayaran); ?></h3></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php include 'template/footer.php'?>
