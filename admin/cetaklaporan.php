<?php
// Panggil skrip koneksi yang ada di dalam file koneksi.php
include 'template/header.php';

// Pastikan ada data yang dikirimkan dari form sebelum memprosesnya
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data yang dikirimkan dari form
    $dariTanggal = $_POST['dariTanggal'];
    $sampaiTanggal = $_POST['sampaiTanggal'];
    $layanan = $_POST['layanan'];
    $status = $_POST['status'];

    // Lakukan pengolahan data dan pembuatan laporan sesuai dengan kebutuhan
    // Misalnya, Anda dapat melakukan kueri SQL untuk mengambil data dari database berdasarkan parameter yang diberikan

    // Contoh kueri SQL untuk mengambil data berdasarkan parameter yang diberikan
    $ambil_data = $conn->query("SELECT * FROM checkout WHERE layanan = '$layanan' AND status = '$status' AND tanggal BETWEEN '$dariTanggal' AND '$sampaiTanggal'");

    // Set header untuk melakukan cetak laporan
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_$layanan_$status.xls");
    
    // Tampilkan data dalam format tabel HTML
    echo "<table border='1'>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Harga</th>
            </tr>";
    
    $no = 1;
    while ($data = $ambil_data->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $data['nama'] . "</td>";
        echo "<td>" . $data['tanggal'] . "</td>";
        echo "<td>" . $data['status'] . "</td>";
        echo "<td>" . $data['harga'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    // Jika tidak ada data yang dikirimkan dari form, kembalikan pengguna ke halaman sebelumnya atau lakukan penanganan sesuai dengan kebutuhan
    echo "Tidak ada data yang ditemukan.";
}
?>
