<?php include 'template/header.php';

$layanan_id = $_GET['layanan_id'];
$layanan = $conn->query("SELECT * FROM layanan WHERE layanan_id = '$layanan_id'");
$layanan = $layanan->fetch_assoc();

if (isset($_POST['editLayanan'])) {
    $layanan_nama = $_POST['layanan_nama'];
    $layanan_deskripsi = $_POST['layanan_deskripsi'];
    $layanan_harga = $_POST['layanan_harga'];

    $conn->query("UPDATE layanan SET layanan_nama = '$layanan_nama', layanan_deskripsi = '$layanan_deskripsi', layanan_harga = '$layanan_harga' WHERE layanan_id = '$layanan_id'");

    echo "<script>alert('Data Layanan Berhasil Diubah')</script>";
    echo "<script>location = 'layanan.php'</script>";
}

?>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-red">
        <a class="navbar-brand ps-3">Pojok Shoescare</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!"><b>Hallo Admin</b></a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div class="container-fluid px-4">
        <h1 class="mt-4 ">Edit Layanan</h1>
        <div class="d-flex flex-column flex-md-row gap-2">
            <div class="card col-xl-6 mb-4 ">
                <div class="card-header text-center">
                    Edit Layanan
                </div>
                <div class="card-body">
                    <form id="editLayananForm" method="post">
                        <div class="form-group mb-3">
                            <label for="editLayananDeepClean">Nama Layanan</label>
                            <input type="text" class="form-control" id="editLayananDeepClean" placeholder="Masukan Nama Layanan" name="layanan_nama" value="<?php echo $layanan['layanan_nama']; ?>" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="editHargaDeepClean">Harga</label>
                            <input type="text" class="form-control" id="editHargaDeepClean" placeholder="Masukan Harga" name="layanan_harga" value="<?php echo $layanan['layanan_harga']; ?>" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="editDeskripsiDeepClean"> Deskripsi</label>
                            <input type="text" class="form-control" id="editDeskripsiDeepClean" placeholder="Masukan Deskripsi Layanan" name="layanan_deskripsi" value="<?php echo $layanan['layanan_deskripsi']; ?>" />
                        </div>
                        <button type="submit" class="btn btn-primary" name="editLayanan">Simpan</button>
                        <a href="layanan.php" class="btn btn-danger text-white">Batal</a>
                    </form>
                </div>
            </div>
            <div class="card col-xl-6 mb-4">
                <div class="card-header text-center">
                    Edit Gambar
                </div>
                <div class="card-body">
                    <form id="editImageForm" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <img id="previewImage" src="<?php echo $layanan['layanan_picture'] ?? 'assets/assets/img/fastdeep.jpg'; ?>" class="card-img-top" alt="Preview Image" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="picture">Pilih Gambar</label>
                            <input type="file" class="form-control" id="picture" name="picture" accept="image/*" onchange="previewImageHandler();">
                        </div>
                        <!-- Tombol Simpan hanya muncul setelah gambar dipilih -->
                        <button type="button" class="btn btn-primary" id="submitImageButton" onclick="submitImage()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk preview gambar yang dipilih
        function previewImageHandler() {
            var file = document.getElementById("picture").files[0];
            var reader = new FileReader();
            reader.onloadend = function() {
                // Update gambar yang ditampilkan dengan gambar yang dipilih
                document.getElementById("previewImage").src = reader.result;
                // Tampilkan tombol simpan ketika gambar dipilih
                document.getElementById("submitImageButton").style.display = "block";
            }
            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Fungsi untuk mengirimkan gambar ke API menggunakan JavaScript (AJAX)
        function submitImage() {
            var formData = new FormData(document.getElementById('editImageForm'));

            // Ambil layanan_id dari query string (misalnya ?layanan_id=123)
            var urlParams = new URLSearchParams(window.location.search);
            var layanan_id = urlParams.get('layanan_id');

            // Ubah URL endpoint dengan layanan_id
            var endpoint = `https://staging.lestarikehari.com/api/layanan/picture/${layanan_id}`;

            fetch(endpoint, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Gambar berhasil diupdate!');
                        document.getElementById("submitImageButton").style.display = "none"; // Sembunyikan tombol setelah berhasil
                    } else {
                        alert('Terjadi kesalahan saat mengupdate gambar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data');
                });
        }
    </script>
</body>

<?php include 'template/footer.php' ?>