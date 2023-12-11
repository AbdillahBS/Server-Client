<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: admin.php"); // Arahkan ke halaman admin jika sudah login
    exit();
}

include 'client_pengguna.php';
$client = new Client($url);
$conn = $client->getPDOConnection(); // Mendapatkan koneksi PDO

// Periksa koneksi
if (!$conn) {
    // Koneksi gagal, atur pesan kesalahan atau tindakan yang diperlukan
    die("Koneksi ke database gagal");
}

if (isset($_POST['aksi']) && $_POST['aksi'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Lakukan verifikasi login di sini, misalnya dengan metode dari objek $abc
    $data = array(
        "username" => $username,
        "password" => $password,
        "nama" => $nama,
        "aksi" => "login"
    );

    $data2 = $abc->login($data); // Misalkan login() adalah fungsi untuk memeriksa login dari objek $abc

    // Periksa apakah login berhasil
    if ($data2) {
        // Login berhasil
        $_SESSION['pengguna'] = $nama;
        $_SESSION['admin'] = true;
        echo "<script>alert('Berhasil login')</script>";
        echo "<script>document.location.href='admin.php'</script>";
        exit();
    } else {
        // Login gagal
        $error = "Username atau password salah!";
        echo "<script>alert('Username atau password salah!')</script>";
        // Set alert untuk menampilkan pesan error pada halaman login
        $_SESSION['error'] = $error;
        header("Location: login.php"); // Kembali ke halaman login
        exit();
    }
}
