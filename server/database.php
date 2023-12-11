<?php
class Database
{
	private $host = "localhost";
	private $dbname = "admin1";
	private $user = "root";
	private $password = "";
	private $port = "3306";
	private $conn;

	// function yang pertama kali di-load saat class dipanggil
	public function __construct()
	{	// koneksi database
		try {
			$this->conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8", $this->user, $this->password);
		} catch (PDOException $e) {
			echo "Koneksi gagal";
		}
	}

	// function untuk menghapus selain huruf dan angka
	public function filter($data)
	{
		$data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
		return $data;
		unset($data);
	}
	public function login($data)
	{
		$query = $this->conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
		$query->execute(array($data['username'], $data['password']));
		$data = $query->fetch(PDO::FETCH_ASSOC);
		return $data;
		$query->closeCursor();
		unset($data);
	}


	public function tampil_semua_kategori()
	{
		$query = $this->conn->prepare("select * from kategori order by id_kategori");
		$query->execute();
		// mengambil banyak data dengan fetchAll	
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		// mengembalikan data	
		return $data;
		// hapus variable dari memory	
		$query->closeCursor();
		unset($data);
	}
	public function tampil_semua_pengguna()
	{
		$query = $this->conn->prepare("select * from admin order by id");
		$query->execute();
		// mengambil banyak data dengan fetchAll	
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		// mengembalikan data	
		return $data;
		// hapus variable dari memory	
		$query->closeCursor();
		unset($data);
	}
	public function tampil_semua_artikel()
	{
		$query = $this->conn->prepare("SELECT artikel.*, kategori.nama AS nama_kategori, admin.nama AS penulis FROM artikel INNER JOIN kategori ON artikel.id_kategori = kategori.id_kategori INNER JOIN admin ON artikel.id = admin.id");
		$query->execute();
		// mengambil banyak data dengan fetchAll	
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		// mengembalikan data	
		return $data;
		// hapus variable dari memory	
		$query->closeCursor();
		unset($data);
	}
	public function tampil_semua_komentar()
	{
		$query = $this->conn->prepare("SELECT komentar.*, artikel.judul AS nama_artikel, kategori.nama AS nama_kategori FROM komentar INNER JOIN artikel ON komentar.id_artikel = artikel.id_artikel INNER JOIN kategori ON komentar.id_kategori = kategori.id_kategori");
		$query->execute();
		// mengambil banyak data dengan fetchAll	
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		// mengembalikan data	
		return $data;
		// hapus variable dari memory	
		$query->closeCursor();
		unset($data);
	}


	public function tambah_kategori($data)
	{
		$query = $this->conn->prepare("INSERT IGNORE INTO kategori (id_kategori, nama, tipe, keterangan) VALUES (?, ?, ?, ?)");
		$query->execute(array($data['id_kategori'], $data['nama'], $data['tipe'], $data['keterangan'],));
		$query->closeCursor();
		unset($data);
	}
	public function tambah_pengguna($data)
	{
		$query = $this->conn->prepare("INSERT IGNORE INTO admin (id, nama, username, password, level) VALUES (?, ?, ?, ?, ?)");
		$query->execute(array($data['id'], $data['nama'], $data['username'], $data['password'], $data['level']));
		$query->closeCursor();
		unset($data);
	}
	public function tambah_artikel($data)
	{
		$query = $this->conn->prepare("INSERT INTO artikel (id_artikel, id, tanggal, judul, id_kategori, isi) VALUES (?, ?, ?, ?, ?, ?)");
		$query->execute(array($data['id_artikel'], $data['id'], $data['tanggal'], $data['judul'], $data['id_kategori'], $data['isi']));
		$query->closeCursor();
		unset($data);
	}

	public function ubah_kategori($data)
	{
		$query = $this->conn->prepare("UPDATE kategori SET nama=?, tipe=?, keterangan=? WHERE id_kategori=?");
		$query->execute(array($data['nama'], $data['tipe'], $data['keterangan'], $data['id_kategori']));
		$query->closeCursor();
		unset($data);
	}
	public function ubah_pengguna($data)
	{
		$query = $this->conn->prepare("UPDATE admin SET nama=?, username=?, password=?, level=? WHERE id=?");
		$query->execute(array($data['nama'], $data['username'], $data['password'], $data['level'], $data['id']));
		$query->closeCursor();
		unset($data);
	}


	public function hapus_kategori($id_kategori)
	{
		$query = $this->conn->prepare("delete from kategori where id_kategori=?");
		$query->execute(array($id_kategori));
		$query->closeCursor();
		unset($id_kategori);
	}
	public function hapus_pengguna($id_kategori)
	{
		$query = $this->conn->prepare("delete from admin where id=?");
		$query->execute(array($id_kategori));
		$query->closeCursor();
		unset($id_kategori);
	}
}
