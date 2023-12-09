<?php
include "client.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'tambah') {
        if (isset($_POST['id_kategori'], $_POST['nama'], $_POST['tipe'], $_POST['keterangan'])) {
            $data = array(
                "id_kategori" => $_POST['id_kategori'],
                "nama" => $_POST['nama'],
                "tipe" => $_POST['tipe'],
                "keterangan" => $_POST['keterangan'],
                "aksi" => $_POST['aksi']
            );
            $abc->tambah_kategori($data);
            echo "<script>alert('Berhasil')</script>";
            echo "<script>document.location.href='kategori.php'</script>";
            exit(); // Keluar dari skrip setelah menampilkan pesan
        } else {
            echo "<script>alert('Gagal menambahkan data')</script>";
            echo "<script>document.location.href='kategori.php'</script>";
            exit();
        }
    } else if ($_POST['aksi'] == 'ubah') {
        $data = array(
            "id_kategori" => $_POST['id_kategori'],
            "nama" => $_POST['nama'],
            "tipe" => $_POST['tipe'],
            "keterangan" => $_POST['keterangan'],
            "aksi" => $_POST['aksi']
        );
        $abc->ubah_kategori($data);
        echo "<script>alert('Berhasil mengubah data')</script>";
        echo "<script>document.location.href='kategori.php'</script>";
        exit(); // Keluar dari skrip setelah menampilkan pesan
    } else {
        echo "<script>alert('Gagal mengubah data')</script>";
        echo "<script>document.location.href='kategori.php'</script>";
        exit();
    }
} else if ($_GET['aksi'] == 'hapus') {
    $data = array(
        "id_kategori" => $_GET['id_kategori'],
        "aksi" => $_GET['aksi']
    );
    $abc->hapus_kategori($data);
    echo "<script>alert('Data berhasil dihapus')</script>";
    echo "<script>document.location.href='kategori.php'</script>";
    exit(); // Keluar dari skrip setelah menampilkan pesan
} else {
    echo "<script>alert('Gagal menghapus data')</script>";
    echo "<script>document.location.href='kategori.php'</script>";
    exit();
} // Keluar dari skrip setelah menampilkan pesan


unset($data, $abc);
