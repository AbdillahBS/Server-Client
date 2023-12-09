<?php
// Koneksi ke database
include 'koneksi.php';

// Memastikan koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil ID artikel dari parameter GET
$id_artikel = $_GET['id'];

// Query untuk mengambil data artikel berdasarkan ID
$query = "SELECT artikel.*, kategori.nama AS nama_kategori, admin.nama AS penulis FROM artikel INNER JOIN kategori ON artikel.id_kategori = kategori.id_kategori INNER JOIN admin ON artikel.id = admin.id WHERE artikel.id_artikel = '$id_artikel'";
$result = mysqli_query($conn, $query);

// Memeriksa apakah artikel ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Menyiapkan data artikel dalam bentuk array
    $artikel = [
        'penulis' => $row['penulis'],
        'tanggal' => $row['tanggal'],
        'judul' => $row['judul'],
        'id_kategori' => $row['id_kategori'],
        'isi' => $row['isi']
    ];

    // Mengembalikan data artikel dalam format JSON
    echo json_encode($artikel);
} else {
    // Jika artikel tidak ditemukan, mengembalikan pesan error
    echo json_encode(['error' => 'Artikel tidak ditemukan']);
}

// Menutup koneksi ke database
mysqli_close($conn);
?>
