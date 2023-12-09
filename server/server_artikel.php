<?php
error_reporting(1);
include "database.php";
$abc = new Database();

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
    // cache for 1 day
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}
$postdata = file_get_contents("php://input");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode($postdata);
    $id = $data->id;
    $id_artikel = $data->id_artikel;
    $tanggal = $data->tanggal;
    $judul = $data->judul;
    $id_kategori = $data->id_kategori;
    $isi = $data->isi;
    $aksi = $data->aksi;

    if ($aksi == 'tambah') {
        $data2 = array(
            'id_artikel' => $id_artikel,
            'id' => $id,
            'tanggal' => $tanggal,
            'judul' => $judul,
            'id_kategori' => $id_kategori,
            'isi' => $isi
        );
        $abc->tambah_artikel($data2);
    } elseif ($aksi == 'ubah') {
        $data2 = array(
            'id_artikel' => $id_artikel,
            'id' => $id,
            'tanggal' => $tanggal,
            'judul' => $judul,
            'id_kategori' => $id_kategori,
            'isi' => $isi
        );
        $abc->ubah_pengguna($data2);
    } elseif ($aksi == 'hapus') {
        $abc->hapus_pengguna($id_artikel);
    }
    // hapus variable dari memory
    unset($postdata, $data, $data2, $id_artikel, $tanggal, $aksi, $abc);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_artikel']))) {
        $id_artikel = $abc->filter($_GET['id_artikel']);
        $data = $abc->tampil_semua_kategori($id_artikel);
        echo json_encode($data);
    } else  //menampilkan semua data 
    {
        $data = $abc->tampil_semua_artikel();
        echo json_encode($data);
    }
    unset($postdata, $data, $id_artikel, $abc);
}
