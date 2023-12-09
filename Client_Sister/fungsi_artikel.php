<?php
include 'koneksi.php';

// Proses penambahan artikel
if (isset($_POST['tombolSimpanArtikel'])) {
    // Ambil data dari form
    $penulis = $_POST['penulis'];
    $tanggal = $_POST['tanggal'];
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isiartikel'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $folder = "asset/";

    // Generate nama unik untuk gambar
    $nama_file = uniqid() . '_' . $gambar;
    $tujuan_file = $folder . $nama_file;

    // Validasi tipe file gambar
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = $_FILES['gambar']['type'];

    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Tipe file gambar tidak valid. Hanya gambar dengan format JPEG, PNG, atau GIF yang diperbolehkan.');</script>";

        exit();
    }

    // Validasi ukuran gambar
    $max_size = 2 * 1024 * 1024; // 2 MB
    $file_size = $_FILES['gambar']['size'];

    if ($file_size > $max_size) {
        echo "<script>alert('Ukuran file gambar terlalu besar. Maksimum ukuran file adalah 2MB.');</script>";
        exit();
    }

    move_uploaded_file($gambar_tmp, $tujuan_file);

    // Simpan data ke tabel artikel
    // Ambil ID penulis berdasarkan nama
    $query_penulis = "SELECT id FROM admin WHERE nama=?";
    $stmt_penulis = mysqli_prepare($conn, $query_penulis);
    mysqli_stmt_bind_param($stmt_penulis, 's', $penulis);
    mysqli_stmt_execute($stmt_penulis);
    mysqli_stmt_bind_result($stmt_penulis, $penulis_id);
    mysqli_stmt_fetch($stmt_penulis);
    mysqli_stmt_close($stmt_penulis);

    // Simpan data ke tabel artikel
    $query_artikel = "INSERT INTO artikel (id, tanggal, judul, id_kategori, isi) VALUES (?, ?, ?, ?, ?)";
    $stmt_artikel = mysqli_prepare($conn, $query_artikel);
    mysqli_stmt_bind_param($stmt_artikel, 'isssss', $penulis_id, $tanggal, $judul, $kategori, $isi);

    $result = mysqli_stmt_execute($stmt_artikel);

    if ($result) {
        $success_message = "Data berhasil diperbarui";
        header("Location: artikel.php?success_message=" . urlencode($success_message));
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan artikel.');</script>";
        exit();
    }
}


// Proses update artikel
else if (isset($_POST['tombolUpdateArtikel'])) {
    $id_artikel = $_POST['id_artikel'];
    $penulis_nama = $_POST['edtpenulis'];
    $tanggal = $_POST['edttanggal'];
    $judul = $_POST['edtjudul'];
    $kategori = $_POST['edtkategori'];
    $isiartikel = $_POST['editisiartikel'];

    // Ambil ID penulis berdasarkan nama
    $query_penulis = "SELECT id FROM admin WHERE nama=?";
    $stmt_penulis = mysqli_prepare($conn, $query_penulis);
    mysqli_stmt_bind_param($stmt_penulis, 's', $penulis_nama);
    mysqli_stmt_execute($stmt_penulis);
    mysqli_stmt_bind_result($stmt_penulis, $penulis_id);
    mysqli_stmt_fetch($stmt_penulis);
    mysqli_stmt_close($stmt_penulis);

    if (isset($_FILES['editgambar']) && $_FILES['editgambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = $_FILES['editgambar']['name'];
        $gambar_tmp = $_FILES['editgambar']['tmp_name'];
        $folder = "asset/";

        // Generate nama unik untuk gambar
        $nama_file = uniqid() . '_' . $gambar;
        $tujuan_file = $folder . $nama_file;

        // Validasi tipe file gambar
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['editgambar']['type'];

        if (!in_array($file_type, $allowed_types)) {
            $error_message = "Tipe file gambar tidak valid. Hanya gambar dengan format JPEG, PNG, atau GIF yang diperbolehkan.";
            header("Location: artikel.php?error_message=" . urlencode($error_message));
            exit();
        }

        // Validasi ukuran gambar
        $max_size = 2 * 1024 * 1024; // 2 MB
        $file_size = $_FILES['editgambar']['size'];

        if ($file_size > $max_size) {
            $error_message = "Ukuran file gambar terlalu besar. Maksimum ukuran file adalah 2MB.";
            header("Location: artikel.php?error_message=" . urlencode($error_message));
            exit();
        }

        move_uploaded_file($gambar_tmp, $tujuan_file);


        // Hapus file gambar sebelumnya jika ada
        $query_gambar_sebelumnya = "SELECT upload FROM artikel WHERE id_artikel=?";
        $stmt_gambar_sebelumnya = mysqli_prepare($conn, $query_gambar_sebelumnya);
        mysqli_stmt_bind_param($stmt_gambar_sebelumnya, 'i', $id_artikel);
        mysqli_stmt_execute($stmt_gambar_sebelumnya);
        mysqli_stmt_bind_result($stmt_gambar_sebelumnya, $gambar_sebelumnya);
        mysqli_stmt_fetch($stmt_gambar_sebelumnya);
        mysqli_stmt_close($stmt_gambar_sebelumnya);

        if ($gambar_sebelumnya !== null) {
            $folder = "asset/";
            $file_path = $folder . $gambar_sebelumnya;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        // Update data artikel termasuk gambar
        $query = "UPDATE artikel SET id=?, tanggal=?, judul=?, id_kategori=?, isi=?, upload=? WHERE id_artikel=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'isssssi', $penulis_id, $tanggal, $judul, $kategori, $isiartikel, $nama_file, $id_artikel);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $success_message = "Data berhasil diperbarui";
            header("Location: artikel.php?success_message=" . urlencode($success_message));
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan artikel: " . mysqli_error($conn);
            header("Location: artikel.php?error_message=" . urlencode($error_message));
            exit();
        }
    } else {
        // Update data artikel tanpa mengubah gambar
        $query = "UPDATE artikel SET id=?, tanggal=?, judul=?, id_kategori=?, isi=? WHERE id_artikel=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'issssi', $penulis_id, $tanggal, $judul, $kategori, $isiartikel, $id_artikel);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $success_message = "Data berhasil diperbarui";
            header("Location: artikel.php?success_message=" . urlencode($success_message));
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan artikel: " . mysqli_error($conn);
            header("Location: artikel.php?error_message=" . urlencode($error_message));
            exit();
        }
    }
}

// Proses penghapusan artikel
else if (isset($_GET['id'])) {
    $id_artikel = $_GET['id'];

    // Ambil nama file gambar sebelum menghapus artikel
    $query = "SELECT upload FROM artikel WHERE id_artikel=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_artikel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $gambar);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Hapus data artikel dari database
    $query = "DELETE FROM artikel WHERE id_artikel=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_artikel);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        // Hapus file gambar dari folder jika ada
        if ($gambar !== null) {
            $folder = "asset/";
            $file_path = $folder . $gambar;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $success_message = "Data berhasil dihapus";
        header("Location: artikel.php?success_message=" . urlencode($success_message));
        exit();
    } else {
        $error_message = "Terjadi kesalahan saat menghapus artikel: " . mysqli_error($conn);
        header("Location: artikel.php?error_message=" . urlencode($error_message));
        exit();
    }
}
