<?php
include '../conection.php';

$dariTanggal = '';
$sampaiTanggal = '';
$layanan_id = '';
if (isset($_GET['export'])) {
    $dariTanggal = isset($_GET['dariTanggal']) ? $_GET['dariTanggal'] : '';
    $sampaiTanggal = isset($_GET['sampaiTanggal']) ? $_GET['sampaiTanggal'] : '';
    $layanan_id = isset($_GET['layanan']) ? $_GET['layanan'] : '';

    exportLaporan($dariTanggal, $sampaiTanggal, $layanan_id);
    exit; 
}

include 'template/header.php';

$layanans = $conn->query("SELECT * FROM layanan");
$layanans = $layanans->fetch_all(MYSQLI_ASSOC);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan</h1>
    <div class="card col-xl-6 mb-4">
        <div class="card-header">
            Layanan Shoescare
        </div>
        <div class="card-body">
            <form method="GET">
                <div class="form-group mb-3">
                    <label for="dariTanggal">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dariTanggal" name="dariTanggal" value="<?= $dariTanggal ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="sampaiTanggal">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="sampaiTanggal" name="sampaiTanggal" value="<?= $sampaiTanggal ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="layanan">Pilih Layanan</label>
                    <select class="form-control" name="layanan">
                        <option value="">Pilih Semua Layanan</option>
                        <?php foreach ($layanans as $layanan) : ?>
                            <option value="<?= $layanan['layanan_id'] ?>" <?= $layanan['layanan_id'] == $layanan_id ? 'selected' : '' ?>>
                                <?= $layanan['layanan_nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
            </form>
            <br>
            <a href="?export=true&dariTanggal=<?= $dariTanggal ?>&sampaiTanggal=<?= $sampaiTanggal ?>&layanan=<?= $layanan_id ?>" class="btn btn-success">
                Ekspor Laporan ke CSV
            </a>
        </div>
    </div>
</div>
</main>

<?php include 'template/footer.php' ?>

<?php
function exportLaporan($dariTanggal, $sampaiTanggal, $layanan_id) {
    global $conn;

    $query = "
        SELECT
            c.checkout_id,
            k.keranjang_tanggal,
            p.pelanggan_nama,
            p.pelanggan_email,
            k.keranjang_jumlah_harga,
            c.checkout_waktu,
            c.checkout_status,
            pay.pembayaran_jumlahbayar,
            pay.pembayaran_metode,
            pay.pembayaran_status
        FROM
            checkout c
        JOIN keranjang k ON c.keranjang_id = k.keranjang_id
        JOIN pelanggan p ON k.pelanggan_id = p.pelanggan_id
        LEFT JOIN pembayaran pay ON c.checkout_id = pay.checkout_id
        WHERE 1
    ";

    if ($dariTanggal) {
        $query .= " AND c.checkout_waktu >= '$dariTanggal'";
    }
    if ($sampaiTanggal) {
        $query .= " AND c.checkout_waktu <= '$sampaiTanggal'";
    }
    if ($layanan_id) {
        $query .= " AND EXISTS (
            SELECT 1 FROM detailkeranjang dk
            WHERE dk.keranjang_id = k.keranjang_id
            AND dk.layanan_id = $layanan_id
        )";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();  

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    exportCSV($data);
}

function exportCSV($data) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="laporan_checkout.csv"');
    $output = fopen('php://output', 'w');
    
    fputcsv($output, ['Checkout ID', 'Tanggal Keranjang', 'Nama Pelanggan', 'Email Pelanggan', 'Jumlah Harga', 'Waktu Checkout', 'Status Checkout', 'Jumlah Pembayaran', 'Metode Pembayaran', 'Status Pembayaran']);
    
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}
?>
