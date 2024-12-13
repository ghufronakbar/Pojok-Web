<?php
include 'template/header.php';

$ambil_transaksi = $conn->query("SELECT c.checkout_id, c.checkout_status, p.pelanggan_nama, c.checkout_waktu, pembayaran.pembayaran_jumlahbayar from checkout c left join keranjang kr on c.keranjang_id = kr.keranjang_id left join pelanggan p on kr.pelanggan_id = p.pelanggan_id left join pembayaran on c.checkout_id = pembayaran.checkout_id ORDER BY c.checkout_id DESC");
$transaksi = array();
while ($tiap_transaksi = $ambil_transaksi->fetch_assoc()) {
    $transaksi[] = $tiap_transaksi;
}
function formatRupiah($angka) {
    $rupiah = number_format($angka, 0, ',', '.');
    return "Rp ". $rupiah.",00";
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Transaksi
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Waktu</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi as $transaksi): ?>
                        <tr>
                            <td><?= $transaksi["pelanggan_nama"] ?></td>
                            <td><?= $transaksi["checkout_waktu"] ?></td>
                            <td><?= formatRupiah($transaksi["pembayaran_jumlahbayar"])?></td>
                            <td><?= ucfirst($transaksi["checkout_status"]) ?></td>
                            <td>
                                <a href="detailcheckout.php?checkout_id=<?= $transaksi['checkout_id'] ?>" class="btn btn-primary">Detail</a>                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
<?php include 'template/footer.php'; ?>
