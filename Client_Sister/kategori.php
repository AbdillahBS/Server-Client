<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "client.php";
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
                    <h1 class="mt-4">Data kategori</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Di Halaman Admin</li>
                    </ol>
                    <div class="card mb-4">

                        <div class="card-header py-3">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#myModal" data-aksi="tambah">Tambah kategori</button>
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah kategori</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="proses_kategori.php" method="post">
                                                <input type="hidden" id="aksi" name="aksi" value="">
                                                <div class="mb-3 mt-3">
                                                    <label for="id" class="form-label">id kategori</label>
                                                    <input type="text" class="form-control" id="id_kategori" name="id_kategori">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="nama" class="form-label">Nama kategori</label>
                                                    <input type="text" class="form-control" id="nama" name="nama">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="tipe" class="form-label">Tipe</label>
                                                    <input type="text" class="form-control" id="tipe" name="tipe">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Menangani klik pada tombol "Tambah kategori" untuk mengatur nilai aksi secara default
                            document.addEventListener('DOMContentLoaded', function() {
                                let addButton = document.querySelector('[data-bs-target="#myModal"]');
                                addButton.addEventListener('click', function() {
                                    let aksiInput = document.getElementById('aksi');
                                    if (aksiInput) {
                                        aksiInput.value = addButton.getAttribute('data-aksi');
                                    }
                                });
                            });
                        </script>


                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Kategori
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>nomor</th>
                                        <th>nama</th>
                                        <th>tipe</th>
                                        <th>keterangan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $i = 1;
                                    $data = $abc->tampil_semua_kategori();
                                    foreach ($data as $d) {
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $d->nama; ?></td>
                                            <td><?= $d->tipe; ?></td>
                                            <td><?= $d->keterangan; ?></td>
                                            <td>
                                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="openModal('<?= $d->id_kategori; ?>')">Edit</button>
                                                <!-- <a href="proses_kategori.php?id=<?= $d->id_kategori; ?>" class="btn btn-danger">Hapus</a> -->
                                                <a href="proses_kategori.php?aksi=hapus&id_kategori=<?= $d->id_kategori ?>" role="button" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    unset($data, $d, $i, $abc);
                                    ?>
                                </tbody>
                            </table>

                            <div class="modal" id="editModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit kategori</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="proses_kategori.php" method="post">
                                                <div class="mb-3 mt-3">
                                                    <label for="edit_nama" class="form-label">Nama:</label>
                                                    <input type="text" class="form-control" id="edit_nama" name="nama">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="edit_tipe" class="form-label">Tipe:</label>
                                                    <input type="text" class="form-control" id="edit_tipe" name="tipe">
                                                </div>
                                                <div class="mb-3 mt-3">
                                                    <label for="edit_keterangan" class="form-label">Keterangan:</label>
                                                    <input type="text" class="form-control" id="edit_keterangan" name="keterangan">
                                                </div>
                                                <input type="hidden" id="editAksi" name="aksi" value="ubah">
                                                <input type="hidden" id="editUserId" name="id_kategori">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function openModal(id_kategori) {
                                    var modal = document.getElementById("editModal");
                                    // Tampilkan modal
                                    modal.style.display = "block";

                                    var editAksi = document.getElementById("editAksi");
                                    editAksi.value = "ubah";

                                    // Mengisi form edit dengan data yang sesuai
                                    var userId = document.getElementById("editUserId");
                                    userId.value = id_kategori;

                                    // Mengambil data dari server dan mengisi form edit di dalam modal
                                    var xhr = new XMLHttpRequest();
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            var response = JSON.parse(xhr.responseText);
                                            var nama = document.getElementById("edit_nama");
                                            var tipe = document.getElementById("edit_tipe");
                                            var keterangan = document.getElementById("edit_keterangan");
                                            // Mengisi nilai form dengan data dari server
                                            nama.value = response.nama;
                                            tipe.value = response.tipe;
                                            keterangan.value = response.keterangan;
                                        }
                                    };
                                    xhr.open("GET", "get_kategori.php?id_kategori=" + id_kategori, true);
                                    xhr.send();
                                }

                                function closeModal() {
                                    var modal = document.getElementById("editModal");
                                    // Tutup modal
                                    modal.style.display = "none";
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