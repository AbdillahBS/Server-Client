<?php
error_reporting(1);
include "database.php";
$abc = new Database();

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
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
	$id_kategori = $data->id_kategori;
	$nama = $data->nama;
	$tipe = $data->tipe;
	$keterangan = $data->keterangan;
	$aksi = $data->aksi;

	if ($aksi == 'tambah') {
		$data2 = array(
			'id_kategori' => $id_kategori,
			'nama' => $nama,
			'tipe' => $tipe,
			'keterangan' => $keterangan
		);
		$abc->tambah_kategori($data2);
	} elseif ($aksi == 'ubah') {
		$data2 = array(
			'id_kategori' => $id_kategori,
			'nama' => $nama,
			'tipe' => $tipe,
			'keterangan' => $keterangan
		);
		$abc->ubah_kategori($data2);
	} elseif ($aksi == 'hapus') {
		$abc->hapus_kategori($id_kategori);
	}
	// hapus variable dari memory
	unset($postdata, $data, $data2, $id_kategori, $nama, $aksi, $abc);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_kategori']))) {
		$id_kategori = $abc->filter($_GET['id_kategori']);
		$data = $abc->tampil_semua_kategori($id_kategori);
		echo json_encode($data);
	} else  //menampilkan semua data 
	{
		$data = $abc->tampil_semua_kategori();
		echo json_encode($data);
	}
	unset($postdata, $data, $id, $abc);
}
