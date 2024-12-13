<?php
include 'template/header.php';

$id = $_GET['checkout_id'];

// Ambil detail checkout dari database
$detailCheckout = "SELECT c.checkout_id, c.checkout_status, p.pelanggan_nama, p.pelanggan_alamat, c.checkout_waktu, pembayaran.pembayaran_jumlahbayar, kr.keranjang_id 
                   FROM checkout c 
                   LEFT JOIN keranjang kr ON c.keranjang_id = kr.keranjang_id 
                   LEFT JOIN pelanggan p ON kr.pelanggan_id = p.pelanggan_id 
                   LEFT JOIN pembayaran ON c.checkout_id = pembayaran.checkout_id 
                   WHERE c.checkout_id = '$id'";

$checkout = $conn->query($detailCheckout)->fetch_assoc();

// Ambil detail keranjang
$checkoutItems = $conn->query("SELECT k.detail_id, k.keranjang_id, k.jumlah_sepatu, k.detail_status, l.layanan_nama, l.layanan_harga 
                               FROM detailkeranjang k 
                               LEFT JOIN layanan l ON k.layanan_id = l.layanan_id 
                               WHERE keranjang_id = '$checkout[keranjang_id]'");

$transaksi = array();
while ($tiap_transaksi = $checkoutItems->fetch_assoc()) {
    $transaksi[] = $tiap_transaksi;
}

$totalCostItems = 0;
foreach ($transaksi as $item) {
    $totalCostItems += $item['layanan_harga'] * $item['jumlah_sepatu'];
}
$shippingCost = $checkout['pembayaran_jumlahbayar'] - $totalCostItems;

function formatRupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return "Rp " . $rupiah . ",00";
}

// Pengecekan dan pembaruan status checkout berdasarkan detail status
$allSelesai = true;
$allDipesan = true;

foreach ($transaksi as $item) {
    if ($item['detail_status'] != 'selesai') {
        $allSelesai = false;  // Jika ada item yang tidak selesai
    }
    if ($item['detail_status'] != 'dipesan') {
        $allDipesan = false;  // Jika ada item yang tidak dipesan
    }
}

// Menentukan checkout_status
if ($allSelesai) {
    $newCheckoutStatus = 'Selesai';  // Semua selesai
} elseif ($allDipesan) {
    $newCheckoutStatus = 'Menunggu';  // Semua dipesan
} else {
    $newCheckoutStatus = 'Diproses';  // Selain itu, statusnya diproses
}

// Jika ada perubahan pada checkout_status, update database
if ($checkout['checkout_status'] != $newCheckoutStatus) {
    $updateCheckoutStatusQuery = "UPDATE checkout 
                                  SET checkout_status = LOWER('$newCheckoutStatus') 
                                  WHERE checkout_id = '$id'";

    if ($conn->query($updateCheckoutStatusQuery)) {
        // Jika berhasil mengupdate checkout_status
        $checkout['checkout_status'] = $newCheckoutStatus;  // Update status di variabel
    } else {
        echo "<script>alert('Gagal memperbarui status checkout');</script>";
    }
}

// Proses update status detail jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['detail_status'])) {
    // Iterasi untuk setiap detail_id dan status yang baru
    foreach ($_POST['detail_status'] as $detailId => $newStatus) {
        // Pastikan status dalam bentuk lowercase jika diperlukan
        $newStatus = strtolower($newStatus);

        // Update status di database untuk setiap detail_id
        $updateStatusQuery = "UPDATE detailkeranjang 
                              SET detail_status = '$newStatus' 
                              WHERE detail_id = '$detailId'";

        $conn->query($updateStatusQuery);
    }

    // Redirect setelah update selesai
    echo "<script>window.location.href = 'detailcheckout.php?checkout_id=$id';</script>";
    exit;
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
                                    <td>Status Pemesanan</td>
                                    <td> : </td>
                                    <td><?= ucfirst($checkout['checkout_status']) ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td> : </td>
                                    <td><?= $checkout['pelanggan_alamat'] ?></td>
                                </tr>
                            </table>
                            <h4 class='card-title' style='margin-top: 20px;'>Detail Checkout</h4>

                            <form id="updateStatusForm" method="POST" action="">
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>Nama Layanan</th>
                                            <th>Harga Layanan</th>
                                            <th>Jumlah Sepatu</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($transaksi as $item): ?>
                                        <tr>
                                            <td><?= isset($item['layanan_nama']) ? $item['layanan_nama'] : 'N/A' ?></td>
                                            <td><?= isset($item['layanan_harga']) ? formatRupiah($item['layanan_harga']) : 'N/A' ?></td>
                                            <td><?= isset($item['jumlah_sepatu']) ? $item['jumlah_sepatu'] : 'N/A' ?></td>
                                            <td><?= isset($item['layanan_harga']) ? formatRupiah($item['layanan_harga'] * $item['jumlah_sepatu']) : 'N/A' ?></td>
                                            <td>
                                                <select class="form-control status-dropdown" name="detail_status[<?= $item['detail_id'] ?>]" onchange="updateStatus(this)">
                                                    <option value="dipesan" <?= $item['detail_status'] == 'dipesan' ? 'selected' : '' ?>>Dipesan</option>
                                                    <option value="dijemput" <?= $item['detail_status'] == 'dijemput' ? 'selected' : '' ?>>Dijemput</option>
                                                    <option value="diproses" <?= $item['detail_status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="selesai" <?= $item['detail_status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <!-- Tambahkan tombol untuk submit seluruh form -->
                                <button type="submit" class="btn btn-sm btn-success mt-2">Update Semua Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk menangani onChange dan update status -->
<script>
    function updateStatus(selectElement) {
        var status = selectElement.value;
        var detailId = selectElement.name.replace('detail_status[', '').replace(']', '');

        console.log('Updated Status for Detail ID:', detailId, 'to', status);
        // Anda bisa menambahkan logika lain di sini jika diperlukan untuk memanipulasi form atau menyimpan perubahan sementara
    }
</script>

<?php include 'template/footer.php'; ?>