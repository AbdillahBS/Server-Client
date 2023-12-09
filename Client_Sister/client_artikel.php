<?php
error_reporting(1); // error ditampilkan
class Client
{
    private $host = "localhost";
    private $dbname = "admin";
    private $conn;
    private $url;


    // koneksi ke database mysql di client
    private $driver = "mysql";
    private $user = "root";
    private $password = "";
    private $port = "3306";

    /*
	// koneksi ke database postgresql di client
	private $driver="pgsql";
	private $user="postgres";
	private $password="postgres";
	private $port="5432";
	*/

    // diload pertama kali
    public function __construct($url)
    {
        $this->url = $url;
        try {
            if ($this->driver == 'mysql') {
                $this->conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8", $this->user, $this->password);
            } elseif ($this->driver == 'pgsql') {
                $this->conn = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->user;password=$this->password");
            }
        } catch (PDOException $e) {
            echo "Koneksi gagal";
        }

        // menghapus variable dari memory
        unset($url);
    }

    // function untuk menghapus selain huruf dan angka
    public function filter($data)
    {
        $data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
        return $data;
        unset($data);
    }

    public function tampil_semua_artikel()
    {
        $client = curl_init($this->url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($client);
        curl_close($client);
        $data = json_decode($response);
        // mengembalikan data
        return $data;
        // menghapus variable dari memory
        unset($data, $client, $response);
    }


    public function tambah_pengguna($data)
    {
        $data = '{	"id":"' . $data['id'] . '",
					"nama":"' . $data['nama'] . '",
					"username":"' . $data['username'] . '",
					"password":"' . $data['password'] . '",
					"level":"' . $data['level'] . '",
					"aksi":"' . $data['aksi'] . '"
				}';
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($c);
        curl_close($c);
        unset($data, $c, $response);
    }

    public function ubah_pengguna($data)
    {
        $data = '{  "id":"' . $data['id'] . '",
                    "nama":"' . $data['nama'] . '",
                    "username":"' . $data['username'] . '",
                    "password":"' . $data['password'] . '",
                    "level":"' . $data['level'] . '",
                    "aksi":"ubah"
				}';
        $c = curl_init();

        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($c);
        curl_close($c);
        unset($data, $c, $response);
    }

    public function hapus_pengguna($data)
    {
        $id = $this->filter($data['id']);
        $data = '{	"id":"' . $id . '",
					"aksi":"' . $data['aksi'] . '"
				}';
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($c);
        curl_close($c);
        unset($id, $data, $c, $response);
    }
    // function yang terakhir kali di-load saat class dipanggil
    public function __destruct()
    {    // hapus variable dari memory
        unset($this->url);
    }
}

$url = 'http://10.90.33.234/UAS_Sister/server/server_artikel.php';
// buat objek baru dari class Client
$abc = new Client($url);
