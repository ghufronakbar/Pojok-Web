<?php
include 'template/header.php';

$ambil_layanan = $conn->query("SELECT * FROM layanan");
$layanan = array();
while ($tiap_layanan = $ambil_layanan->fetch_assoc()) {
    $layanan[] = $tiap_layanan;
}
?>

<div class="container-fluid px-4 bg-light">
    <h1 class="mt-4">Layanan </h1>
    <div class="card mb-4">
        <div class="card-header bg-light">
            Layanan Shoescare
        </div>
        <div class="row mt-4 mb-4">
            <div class="card-container">
                <?php foreach ($layanan as $key => $layanan): ?>
                    <div class="card mb-4" style="width: 18rem;">
                        <img src="<?php echo $layanan['layanan_picture'] ? $layanan['layanan_picture'] : 'assets/assets/img/fastdeep.jpg'; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $layanan["layanan_nama"] ?></h5>
                            <p class="card-text"><?php echo $layanan["layanan_deskripsi"] ?></p>
                            <p class="card-text">Rp.<?php echo $layanan["layanan_harga"] ?></p>
                            <a href="editlayanan.php?layanan_id=<?php echo $layanan["layanan_id"]; ?>" class="btn btn-secondary w-100">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
</main>
<?php include 'template/footer.php' ?>