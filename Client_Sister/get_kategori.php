<?php
include 'koneksi.php';

if (isset($_GET['id_kategori'])) {
    $id_kategori = $_GET['id_kategori'];

    // Query untuk mengambil data kategori berdasarkan ID
    $query = "SELECT * FROM kategori WHERE id_kategori = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $kategori = mysqli_fetch_assoc($result);

    // Mengembalikan data kategori sebagai respons JSON
    header('Content-Type: application/json');
    echo json_encode($kategori);
} else {
    // Jika ID tidak ditemukan, kembalikan respons error atau kosong
    // sesuai kebutuhan Anda
    echo "Data not found";
}
