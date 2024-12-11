<?php include 'template/header.php' ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan </h1>
    <div class="card col-xl-6 mb-4">
        <div class="card-header">
            Layanan Shoescare
        </div>
        <div class="card-body">
            <form action="cetaklaporan.php" method="post"> <!-- Mengirimkan data ke skrip laporan cetak -->
                <div class="form-group mb-3">
                    <label for="dariTanggal">Dari Tanggal</label>
                    <input type="date" class="form-control" id="dariTanggal" name="dariTanggal">
                    <!-- Menambahkan name attribute -->
                </div>
                <div class="form-group mb-3">
                    <label for="sampaiTanggal">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="sampaiTanggal" name="sampaiTanggal">
                    <!-- Menambahkan name attribute -->
                </div>
                <div class="form-group mb-3">
                    <label for="layanan">Pilih Layanan</label>
                    <select class="form-control" name="layanan"> <!-- Menambahkan name attribute -->
                        <option>Layanan 1</option>
                        <option>Layanan 2</option>
                        <option>Layanan 3</option>
                        <option>Layanan 4</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status Pemesanan</label>
                    <select class="form-control" name="status"> <!-- Menambahkan input status pemesanan -->
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Cetak Laporan</button>
            </form>
        </div>
    </div>
</div>
</main>
<?php include 'template/footer.php' ?>