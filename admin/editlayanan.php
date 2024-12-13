<?php
include 'template/header.php';

$layanan_id = $_GET['layanan_id'];
$layanan = $conn->query("SELECT * FROM layanan WHERE layanan_id = '$layanan_id'");
$layanan = $layanan->fetch_assoc();

// Proses perubahan data layanan
if (isset($_POST['editLayanan'])) {
    $layanan_nama = $_POST['layanan_nama'];
    $layanan_deskripsi = $_POST['layanan_deskripsi'];
    $layanan_harga = $_POST['layanan_harga'];
    $status = $_POST['status'];

    $conn->query("UPDATE layanan SET layanan_nama = '$layanan_nama', layanan_deskripsi = '$layanan_deskripsi', layanan_harga = '$layanan_harga', status = '$status' WHERE layanan_id = '$layanan_id'");

    echo "<script>alert('Data Layanan Berhasil Diubah')</script>";
    echo "<script>location = 'layanan.php'</script>";
}

if (isset($_POST['submitImage']) && isset($_FILES['picture'])) {
    // Ambil file yang di-upload
    $file = $_FILES['picture'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // Validasi file
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_extensions) && $file_error === 0) {
        if ($file_size < 5000000) { // Maksimal 5MB
            // Ubah URL endpoint sesuai dengan API yang ingin digunakan
            $api_url = "http://localhost:3000/api/layanan/layanan/{$layanan_id}/picture";
            // $api_url = "https://staging.lestarikehati.com/api/layanan/layanan/{$layanan_id}/picture";

            // Persiapkan data untuk multipart/form-data
            $data = [
                'layanan_id' => $layanan_id,
                'picture' => new CURLFile($file_tmp, $file['type'], $file_name) // Gunakan CURLFile untuk mengirim file
            ];

            // Inisialisasi cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: multipart/form-data'
            ]);

            // Eksekusi cURL
            $response = curl_exec($ch);

            // Debugging - Menampilkan respon dari server
            // echo "<pre>";
            // print_r($response); // Menampilkan respons API
            // echo "</pre>";

            // Periksa jika ada error pada cURL
            if (curl_errno($ch)) {
                echo "<script>alert('Terjadi kesalahan saat mengirim gambar: " . curl_error($ch) . "');</script>";
                error_log("Error cURL: " . curl_error($ch)); // Log cURL error
            } else {
                // Decode respons dari API
                $response_data = json_decode($response, true);

                // Log status HTTP dan respons API
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                error_log("HTTP Status: " . $http_status); // Log status HTTP
                error_log("Response dari API: " . $response); // Log respons API

                // Cek pesan dalam respons untuk memastikan sukses
                if (isset($response_data['message']) && $response_data['message'] === 'Layanan berhasil diperbarui') {
                    // echo "<script>window.location.reload();</script>";                    
                    echo "<script>alert('Gambar berhasil diupdate!');</script>";
                } else {
                    echo "<script>alert('Gagal mengupdate gambar.');</script>";
                }
            }

            // Tutup cURL
            curl_close($ch);
        } else {
            echo "<script>alert('Ukuran file terlalu besar!');</script>";
        }
    } else {
        echo "<script>alert('Format file tidak valid. Pastikan file gambar yang diupload berformat jpg, jpeg, png, atau gif.');</script>";
    }
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
                        <div class="form-group mb-3">
                            <label for="editDeskripsiDeepClean"> Status</label>
                            <select class="form-control" name="status">
                                <option value="1" <?php if ($layanan["status"] == 1) echo "selected"; ?>>Aktif</option>
                                <option value="0" <?php if ($layanan["status"] == 0) echo "selected"; ?>>Tidak Aktif</option>
                            </select>
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
                        <button type="submit" class="btn btn-primary" name="submitImage">Simpan</button>
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
    </script>
</body>

<?php include 'template/footer.php' ?>