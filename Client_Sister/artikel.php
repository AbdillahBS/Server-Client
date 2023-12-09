<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
include 'client_artikel.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin</title>
    <!--<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />-->
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Tambahkan link ke library jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tambahkan link ke library Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="admin.php">Admin</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>

                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-table-columns"></i></div>
                            dashboard
                        </a>

                        <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            Menu utama
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">

                                <a class="nav-link" href="pengguna.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                                    Pengguna
                                </a>

                                <a class="nav-link" href="artikel.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                                    Artikel
                                </a>

                                <a class="nav-link" href="kategori.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                                    kategori
                                </a>

                                <a class="nav-link" href="komentar.php">
                                    <div class="sb-nav-link-icon"><i class="fa-regular fa-comment"></i></div>
                                    komentar
                                </a>

                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading"></div>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <p>
                        <?= $_SESSION["pengguna"]; ?>
                    </p>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data artikel</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Di Halaman Admin</li>
                    </ol>

                    <div class="card mb-6">
                        <div class="card-header py-4">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Tambah artikel</button>
                            <div class="modal" id="myModal">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah artikel</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">

                                            <!-- Form penambahan artikel -->
                                            <form method="post" action="fungsi_artikel.php" enctype="multipart/form-data">
                                                <div class="mb-3 mt-3">
                                                    <label for="penulis" class="form-label">Penulis:</label>
                                                    <input type="text" class="form-control" value="<?= $_SESSION["pengguna"]; ?>" id="penulis" name="penulis" readonly>
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="pwd" class="form-label">Tanggal :</label>
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta'); // Mengatur zona waktu menjadi WIB
                                                    $tanggal = date('Y-m-d'); // Mendapatkan tanggal sekarang dalam format Y-m-d
                                                    ?>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul" class="form-label">Judul:</label>
                                                    <input type="text" class="form-control" id="judul" placeholder="Judul Artikel" name="judul" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kategori" class="form-label">Kategori:</label>
                                                    <select class="form-select" id="kategori" name="kategori">
                                                        <?php
                                                        // Kode PHP untuk mengambil data kategori dari database    
                                                        $query = "SELECT * FROM kategori";
                                                        $result = mysqli_query($conn, $query);

                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo '<option value="' . $row['id_kategori'] . '">' . $row['nama'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="isiartikel" class="form-label">Isi Artikel:</label>
                                                    <textarea class="form-control" id="isiartikel" name="isiartikel" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gambar" class="form-label">Gambar:</label>
                                                    <input class="form-control" type="file" id="gambar" name="gambar" required>
                                                </div>
                                                <button type="submit" name="tombolSimpanArtikel" class="btn btn-primary">Submit</button>
                                            </form>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#isiartikel').summernote({
                                    placeholder: 'Isi artikel...',
                                    height: 500
                                });
                            });
                        </script>

                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data artikel
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Penulis</th>
                                        <th>Tanggal</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $data = $abc->tampil_semua_artikel();
                                    foreach ($data as $d) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $i++; ?>
                                            </td>
                                            <td>
                                                <?= $d->penulis; ?>
                                            </td>
                                            <td>
                                                <?= $d->tanggal; ?>
                                            </td>
                                            <td>
                                                <?= $d->judul; ?>
                                            </td>
                                            <td>
                                                <?= $d->nama_kategori; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="openModal('<?= $d->id_artikel; ?>')">Edit</button>
                                                <a href="fungsi_artikel.php?id=<?= $d->id_artikel; ?>" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Bagian modal Edit Artikel -->
                            <div class="modal" id="editModal">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Artikel</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="fungsi_artikel.php" enctype="multipart/form-data">
                                                <input type="hidden" id="id_artikel" name="id_artikel">
                                                <div class="mb-3 mt-3">
                                                    <label for="edtpenulis" class="form-label">Penulis:</label>
                                                    <input type="text" class="form-control" id="edtpenulis" name="edtpenulis">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="edttanggal" class="form-label">Tanggal:</label>
                                                    <input type="date" class="form-control" id="edttanggal" name="edttanggal">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edtjudul" class="form-label">Judul:</label>
                                                    <input type="text" class="form-control" id="edtjudul" placeholder="Judul Artikel" name="edtjudul">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edtkategori" class="form-label">Kategori:</label>
                                                    <select class="form-select" id="edtkategori" name="edtkategori">
                                                        <?php
                                                        // Kode PHP untuk mengambil data kategori dari database
                                                        $query = "SELECT * FROM kategori";
                                                        $result = mysqli_query($conn, $query);

                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo '<option value="' . $row['id_kategori'] . '">' . $row['nama'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editisiartikel" class="form-label">Isi Artikel:</label>
                                                    <textarea class="form-control" id="editisiartikel" name="editisiartikel"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editgambar" class="form-label">Gambar:</label>
                                                    <input class="form-control" type="file" id="editgambar" name="editgambar">
                                                </div>
                                                <button type="submit" name="tombolUpdateArtikel" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#editisiartikel').summernote({
                                        placeholder: 'Isi artikel...',
                                        height: 300
                                    });
                                });

                                function openModal(id) {
                                    var modal = $('#editModal');
                                    modal.modal('show');

                                    // Mengisi form edit dengan data yang sesuai
                                    $('#id_artikel').val(id);

                                    // Mengambil data artikel dari server menggunakan AJAX
                                    $.ajax({
                                        url: 'get_artikel.php', // Ganti dengan URL yang sesuai untuk mengambil data artikel
                                        method: 'GET',
                                        data: {
                                            id: id
                                        },
                                        success: function(response) {
                                            var artikel = JSON.parse(response);
                                            $('#edtpenulis').val(artikel.penulis);
                                            $('#edttanggal').val(artikel.tanggal);
                                            $('#edtjudul').val(artikel.judul);
                                            $('#edtkategori').val(artikel.id_kategori);
                                            $('#editisiartikel').summernote('code', artikel.isi); // Menyimpan konten HTML di dalam textarea Summernote
                                        },
                                        error: function() {
                                            alert('Terjadi kesalahan saat mengambil data artikel.');
                                        }
                                    });
                                }


                                function closeModal() {
                                    var modal = $('#editModal');
                                    modal.modal('hide');
                                }
                            </script>

                        </div>
                    </div>
                </div>

            </main>
            <footer class="py-4 bg-light mt-auto">

            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


</body>

</html>