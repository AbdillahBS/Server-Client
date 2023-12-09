<?php
// Koneksi ke database dan operasi lain yang diperlukan
include 'koneksi.php';
// Periksa apakah parameter ID telah diberikan dalam permintaan GET
if (isset($_GET['id'])) {
  $userId = $_GET['id'];

  // Lakukan query ke database untuk mengambil data pengguna berdasarkan ID
  // Gantikan bagian ini dengan logika pengambilan data sesuai dengan struktur database Anda
  $query = "SELECT * FROM admin WHERE id = $userId";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Periksa apakah ada data pengguna yang ditemukan
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      // Mengembalikan data pengguna dalam format JSON
      echo json_encode($row);
    } else {
      // Jika tidak ada pengguna dengan ID yang diberikan
      echo "User not found.";
    }
  } else {
    // Jika terjadi kesalahan dalam query
    echo "Error executing query: " . mysqli_error($conn);
  }

  // Membebaskan sumber daya query dan menutup koneksi ke database
  mysqli_free_result($result);
  mysqli_close($conn);
} else {
  // Jika parameter ID tidak diberikan
  echo "Invalid request.";
}
?>
