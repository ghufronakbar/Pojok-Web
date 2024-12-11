<?php include 'conection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Admin Pojok</title>
    <link href="./admin/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="d-flex justify-content-center mt-3">
                                    <img src="./users/assets/assets/img/pojoklogo.jpg" style="width: 10rem;">
                                </div>
                                <div class="card-header">
                                    <h2 class="text-center font-weight-light my-4"> POJOK SHOESCARE <br>"Budayakan
                                        Malas Mencuci, Karena Itu
                                        Tugas Kami"</h2>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" type="text" name="username"
                                                placeholder="Username" />
                                            <label class="form-label">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" type="password" name="password"
                                                placeholder="Password" />
                                            <label class="form-label">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary w-100" name="masuk">Login</button>
                                        </div>
                                    </form>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Pojok Shoecare Website 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <?php
    if (isset($_POST["masuk"])) {

        //inti dari login adalah membandingkan data dari formulir dengan data yang ada di database
        //dapatkan data dari inputan di formulir

        $user = $_POST["username"];
        $password = $_POST["password"];

        //ambil data dari database berdasarkan kolom yang ingin dibandingkan datanya dengan formulir 

        $ambil_admin = $conn->query("SELECT * FROM admin WHERE admin_nama = '$user'");

        //hitung jumlah data yang dibandingkan menggunakan num_rows

        $hitung = $ambil_admin->num_rows;

        //jika $hitung==1 maka lanjut login 
        if ($hitung == 1) {
            $data_admin = $ambil_admin->fetch_assoc();
            // verifikasi password dengan bcrypt
            if (password_verify($password, $data_admin['admin_password'])) {
                $_SESSION["admin"] = $data_admin;
                echo "<script>alert('Login Berhasil Silahkan Masuk')</script>";
                echo "<script>location = 'admin/'</script>";
            } else {
                echo "<script>alert('Login Gagal Silahkan Coba Lagi')</script>";
                echo "<script>location = 'index.php'</script>";
            }
        } else {
            echo "<script>alert('Login Gagal Silahkan Coba Lagi')</script>";
            echo "<script>location = 'index.php'</script>";
        }

    }
    ?>
</body>

</html>