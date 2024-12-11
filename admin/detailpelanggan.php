<?php
include 'template/header.php';

$pelanggan_id = $_GET["id"];

$ambil_pelanggan = $conn->query("SELECT * FROM pelanggan WHERE pelanggan_id = '$pelanggan_id'");
$pelanggan = $ambil_pelanggan->fetch_assoc();

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Pelanggan </h1>
    <div class="card col-xl-6 mb-4">
        <div class="card-header">
            Update Data Pelanggan
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" name="pelanggan_nama" value="<?php echo $pelanggan["pelanggan_nama"] ?>" disabled>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">No Handphone</label>
                    <input type="text" class="form-control" name="pelanggan_notelp" value="<?php echo $pelanggan["pelanggan_nomor"] ?>" disabled>
                </div   >
                <div class="form-group mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="pelanggan_alamat" value="<?php echo $pelanggan["pelanggan_alamat"] ?>" disabled>
                </div>
                <button name="simpan" class="btn btn-primary">Simpan</button>
                <a href="pelanggan.php" class="btn btn-danger text-white">Batal</a>
            </form>
        </div>
    </div>
</div>
</main>
<?php
if (isset($_POST["simpan"])) {
    $nama = $_POST["pelanggan_nama"];
    $telp = $_POST["pelanggan_nomor"];
    $almt = $_POST["pelanggan_alamat"];

    $conn->query("UPDATE pelanggan SET 
		pelanggan_nama = '$nama',
        pelanggan_notelp = '$telp',
        pelanggan_alamat = '$almt' WHERE pelanggan_id = '$pelanggan_id'");

    echo "<script>alert('Berhasil mengubah data')</script>";
    echo "<script>location = 'pelanggan.php'</script>";
}

include 'template/footer.php';
?>