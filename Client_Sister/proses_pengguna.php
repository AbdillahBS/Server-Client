<?php
include "client_pengguna.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Memastikan metode HTTP yang digunakan adalah POST atau GET
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'tambah') {
        $data = array(
            "id" => $_POST['id'],
            "nama" => $_POST['nama'],
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "level" => $_POST['level'],
            "aksi" => $_POST['aksi']
        );
        $abc->tambah_pengguna($data);
        echo "<script>alert('Berhasil menambah data')</script>";
        echo "<script>document.location.href='pengguna.php'</script>";
        exit(); // Keluar dari skrip setelah menampilkan pesan
    } elseif ($_POST['aksi'] == 'login') {
        $data = array(
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "aksi" => $_POST['aksi']
        );
        $data2 = $abc->login($data);
        //echo "<pre>";
        //print_r($data2); //cek $data2
        //echo "</pre>";

        if (isset($data2->level)) {
            setcookie('level', $data2->level, time() + 3600); // hilang dalam 1 jam
            setcookie('username', $data2->username, time() + 3600);
            setcookie('nama', $data2->nama, time() + 3600);
            echo "<script>alert('Berhasil login')</script>";
            echo "<script>document.location.href='admin.php'</script>";
        } else {
            echo "<script>alert('Berhasil menambah data')</script>";
            echo "<script>document.location.href='pengguna.php'</script>";
        }
    } elseif (isset($_POST['aksi']) && $_POST['aksi'] == 'ubah') {
        $data = array(
            "id" => $_POST['id'],
            "nama" => $_POST['nama'],
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "level" => $_POST['level'],
            "aksi" => $_POST['aksi']
        );

        $abc->ubah_pengguna($data);
        echo "<script>alert('Berhasil mengubah data')</script>";
        echo "<script>document.location.href='pengguna.php'</script>";
        exit(); // Keluar dari skrip setelah menampilkan pesan
    } elseif (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
        $data = array(
            "id" => $_GET['id'],
            "aksi" => $_GET['aksi']
        );

        $abc->hapus_pengguna($data);
        echo "<script>alert('Data berhasil dihapus')</script>";
    } else {
        echo "<script>alert('Aksi tidak dikenali')</script>";
    }

    echo "<script>document.location.href='pengguna.php'</script>";
    exit(); // Keluar dari skrip setelah menampilkan pesan
} else {
    echo "<script>alert('Metode HTTP tidak dikenali')</script>";
    echo "<script>document.location.href='pengguna.php'</script>";
    exit();
}
