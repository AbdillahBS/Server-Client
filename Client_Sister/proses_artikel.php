<?php
include "client_artikel.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Memastikan metode HTTP yang digunakan adalah POST atau GET
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'tambah') {
        $data = array(
            "id" => $_POST['id'],
            "tanggal" => $_POST['tanggal'],
            "judul" => $_POST['judul'],
            "id_kategori" => $_POST['id_kategori'],
            "isi" => $_POST['isi'],
            "aksi" => $_POST['aksi']
        );

        $abc->tambah_artikel($data);
        echo "<script>alert('Berhasil')</script>";
        echo "<script>document.location.href='artikel.php'</script>";
        exit(); // Keluar dari skrip setelah menampilkan pesan
    } elseif (isset($_POST['aksi']) && $_POST['aksi'] == 'ubah') {
        $data = array(
            "id_artikel" => $_POST['id_artikel'],
            "id" => $_POST['id'],
            "tanggal" => $_POST['tanggal'],
            "judul" => $_POST['judul'],
            "id_kategori" => $_POST['id_kategori'],
            "isi" => $_POST['isi'],
            "aksi" => $_POST['aksi']
        );

        $abc->ubah_artikel($data);
        echo "<script>alert('Berhasil mengubah data')</script>";
        echo "<script>document.location.href='artikel.php'</script>";
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
