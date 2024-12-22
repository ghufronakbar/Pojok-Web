<?php
include '../conection.php';

// Inisialisasi variabel filter tanggal
$dariTanggal = isset($_GET['dariTanggal']) ? $_GET['dariTanggal'] : '';
$sampaiTanggal = isset($_GET['sampaiTanggal']) ? $_GET['sampaiTanggal'] : '';

// Handle export request
if (isset($_GET['export'])) {
    // Validasi format tanggal
    if (!empty($dariTanggal) && !validateDate($dariTanggal)) {
        die("Format tanggal awal tidak valid");
    }
    if (!empty($sampaiTanggal) && !validateDate($sampaiTanggal)) {
        die("Format tanggal akhir tidak valid");
    }
    
    // Validasi range tanggal
    if (!empty($dariTanggal) && !empty($sampaiTanggal) && strtotime($dariTanggal) > strtotime($sampaiTanggal)) {
        die("Tanggal awal tidak boleh lebih besar dari tanggal akhir");
    }

    exportLaporan($dariTanggal, $sampaiTanggal);
    exit;
}

include 'template/header.php';
?>

<div class="container-fluid px-4 min-vh-100 d-flex flex-column">
    <h1 class="mt-4">Laporan</h1>
    <div class="card col-xl-6 mb-4">
        <div class="card-header">
            Layanan Shoescare
        </div>
        <div class="card-body">
            <form method="GET" id="filterForm">
                <div class="form-group mb-3">
                    <label for="dariTanggal">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dariTanggal" name="dariTanggal" 
                           value="<?= htmlspecialchars($dariTanggal) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="sampaiTanggal">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="sampaiTanggal" name="sampaiTanggal" 
                           value="<?= htmlspecialchars($sampaiTanggal) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <button type="button" class="btn btn-success" onclick="exportData()">
                    Ekspor Laporan ke CSV
                </button>
            </form>
        </div>
    </div>    
</div>

<script>
function exportData() {
    const form = document.getElementById('filterForm');
    const dariTanggal = form.elements['dariTanggal'].value;
    const sampaiTanggal = form.elements['sampaiTanggal'].value;
    
    if (!dariTanggal || !sampaiTanggal) {
        alert('Mohon isi kedua tanggal terlebih dahulu');
        return;
    }
    
    if (new Date(dariTanggal) > new Date(sampaiTanggal)) {
        alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir');
        return;
    }
    
    window.location.href = `?export=true&dariTanggal=${dariTanggal}&sampaiTanggal=${sampaiTanggal}`;
}
</script>

<?php include 'template/footer.php' ?>

<?php
function validateDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function exportLaporan($dariTanggal, $sampaiTanggal) {
    global $conn;

    $query = "
        SELECT
            c.checkout_id,
            p.pelanggan_nama,
            p.pelanggan_email,
            c.checkout_waktu,
            k.keranjang_jumlah_harga,
            pay.pembayaran_metode,
            pay.pembayaran_status
        FROM
            checkout c
        JOIN keranjang k ON c.keranjang_id = k.keranjang_id
        JOIN pelanggan p ON k.pelanggan_id = p.pelanggan_id
        LEFT JOIN pembayaran pay ON c.checkout_id = pay.checkout_id
        WHERE 1=1
    ";

    $params = [];
    $types = "";

    if (!empty($dariTanggal)) {
        $query .= " AND DATE(c.checkout_waktu) >= ?";
        $params[] = $dariTanggal;
        $types .= "s";
    }
    if (!empty($sampaiTanggal)) {
        $query .= " AND DATE(c.checkout_waktu) <= ?";
        $params[] = $sampaiTanggal;
        $types .= "s";
    }

    $query .= " ORDER BY c.checkout_waktu DESC";

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();    

    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="laporan_' . date('Y-m-d') . '.csv"');
    
    // Create CSV file
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // Add BOM for UTF-8
    
    // Write headers
    fputcsv($output, [
        'No',
        'ID Checkout',
        'Nama Pelanggan',
        'Email',
        'Waktu Checkout',
        'Total (Rp)',
        'Metode Pembayaran',
        'Status Pembayaran'
    ]);
    
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $no++,
            $row['checkout_id'],
            $row['pelanggan_nama'],
            $row['pelanggan_email'],
            date('Y-m-d H:i:s', strtotime($row['checkout_waktu'])),
            number_format($row['keranjang_jumlah_harga'], 0, ',', '.'),
            $row['pembayaran_metode'],
            $row['pembayaran_status']
        ]);
    }
    
    fclose($output);
    exit;
}
?>