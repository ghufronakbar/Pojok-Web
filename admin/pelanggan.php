<?php 
include 'template/header.php';

$ambil_pelanggan = $conn -> query("SELECT * FROM pelanggan ORDER BY pelanggan_nama");
$pelanggan = array();
while ($tiap_pelanggan = $ambil_pelanggan -> fetch_assoc()) 
{
	$pelanggan[] = $tiap_pelanggan;
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Pelanggan </h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Pelanggan
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>No Handphone</th>
                        <th>Alamat</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>No Handphone</th>
                        <th>Alamat</th>
                        <th>Tindakan</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php foreach ($pelanggan as $key => $value): ?>
                    <tr>
                        <td><?php echo $value["pelanggan_nama"] ?></td>
                        <td><?php echo $value["pelanggan_nomor"] ?></td>
                        <td><?php echo $value["pelanggan_alamat"] ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm text-white my-1" href="detailpelanggan.php?id=<?php echo $value["pelanggan_id"]; ?>">
                                Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
<?php include 'template/footer.php' ?>