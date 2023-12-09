<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: admin.php"); // Mengarahkan ke halaman login jika belum login
    exit();
}



include 'koneksi.php';
// Memeriksa apakah pengguna sudah submit form login
if (isset($_POST['submit'])) {
    $username = $_POST['usernamee'];
    $password = $_POST['pasword'];

    // Mencocokkan kredensial pengguna dengan yang ada di database
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


    if (mysqli_num_rows($result) == 1) {
        // Login berhasil
        $user_level = $row['level'];
        $nama_pengguna = $row["nama"];
        $_SESSION['username'] = $username;
        $_SESSION['user_level'] = $user_level;
        $_SESSION["pengguna"] = $nama_pengguna;

        // Mengarahkan pengguna sesuai levelnya
        if ($user_level == 'admin') {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
        }
        exit();
    } else {
        // Login gagal
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputusername" type="text"
                                                placeholder="username" name="usernamee" />
                                            <label for="inputusername">username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Password" name="pasword" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit" name="submit">Login</button>
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
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>