<?php
include 'template/header.php';

$id = $_GET['checkout_id'];

$detailCheckout = "SELECT c.checkout_id, c.checkout_status, p.pelanggan_nama, p.pelanggan_alamat, c.checkout_waktu, pembayaran.pembayaran_jumlahbayar, kr.keranjang_id from checkout c left join keranjang kr on c.keranjang_id = kr.keranjang_id left join pelanggan p on kr.pelanggan_id = p.pelanggan_id left join pembayaran on c.checkout_id = pembayaran.checkout_id WHERE c.checkout_id = '$id'";
$checkout = $conn->query($detailCheckout)->fetch_assoc();

$checkoutItems = $conn->query("SELECT k.keranjang_id, k.jumlah_sepatu, l.layanan_nama, l.layanan_harga FROM detailkeranjang k LEFT JOIN layanan l ON k.layanan_id = l.layanan_id WHERE keranjang_id = '$checkout[keranjang_id]'");
$transaksi = array();
while ($tiap_transaksi = $checkoutItems->fetch_assoc()) {
    $transaksi[] = $tiap_transaksi;
}
$totalCostItems = 0;
foreach ($transaksi as $item) {
    $totalCostItems += $item['layanan_harga'] * $item['jumlah_sepatu'];
}
$shippingCost = $checkout['pembayaran_jumlahbayar'] - $totalCostItems;


// echo "jumlahbayar" . $checkout['pembayaran_jumlahbayar'];
// echo "<br/>";
// echo "shippingcost" . $shippingCost;
// echo "<br/>";
// echo "totalCostItems".$totalCostItems;
// echo "<br/>";

function formatRupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return "Rp " . $rupiah . ",00";
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <div class="card mb-4">
        <div class="card-header">
            Detail Transaksi
        </div>
        <div class="card-body">
            <div class="row">
                <div class='col-12 text-right' style="margin-bottom: 20px;">
                    <a href='transaksi.php' class='btn btn-primary'>Kembali</a>
                </div>
            </div>
            <div class='row'>
                <div class='col-12 grid-margin stretch-card'>
                    <div class='card'>
                        <div class='card-body'>
                            <table class='info-table'>

                                <tr>
                                    <td>Nama Pelanggan</td>
                                    <td> : </td>
                                    <td><?= $checkout['pelanggan_nama'] ?></td>
                                </tr>
                                <tr>
                                    <td>Total Checkout</td>
                                    <td> : </td>
                                    <td><?= formatRupiah($checkout['pembayaran_jumlahbayar']) ?></td>
                                </tr>
                                <tr>
                                    <td>Biaya Penjemputan</td>
                                    <td> : </td>
                                    <td><?= formatRupiah($shippingCost) ?></td>
                                </tr>
                                <tr>
                                    <td>Status Checkout</td>
                                    <td> : </td>
                                    <td><?= $checkout['checkout_status'] ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td> : </td>
                                    <td><?= $checkout['pelanggan_alamat'] ?></td>
                                </tr>

                            </table>
                            <h4 class='card-title' style='margin-top: 20px;'>Detail Checkout</h4>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>Nama Layanan</th>
                                        <th>Harga Layanan</th>
                                        <th>Jumlah Sepatu</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <?php foreach ($transaksi as $item): ?>
                                    <tr>
                                        <td><?= isset($item['layanan_nama']) ? $item['layanan_nama'] : 'N/A' ?></td>
                                        <td><?= isset($item['layanan_harga']) ? formatRupiah($item['layanan_harga']) : 'N/A' ?></td>
                                        <td><?= isset($item['jumlah_sepatu']) ? $item['jumlah_sepatu'] : 'N/A' ?></td>
                                        <td><?= isset($item['layanan_harga']) ? formatRupiah($item['layanan_harga'] * $item['jumlah_sepatu']) : 'N/A' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- content-wrapper ends -->
</div>
</div>
</div>
</main>
<?php include 'template/footer.php'; ?>