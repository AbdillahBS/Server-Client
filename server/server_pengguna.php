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
        $nama = $data->nama;
        $username = $data->username;
        $password = $data->password;
        $level = $data->level;
        $aksi = $data->aksi;

        if ($aksi == 'tambah') {
            $data2 = array(
                'id' => $id,
                'nama' => $nama,
                'username' => $username,
                'password' => $password,
                'level' => $level
            );
            $abc->tambah_pengguna($data2);
        } elseif ($aksi == 'login') {
            $data2 = array(
                'username' => $username,
                'password' => $password,
            );
            $abc->login($data2);
            $result = $abc->login($data2);
            echo json_encode($result);
        } elseif ($aksi == 'ubah') {
            $data2 = array(
                'id' => $id,
                'nama' => $nama,
                'username' => $username,
                'password' => $password,
                'level' => $level
            );
            $abc->ubah_pengguna($data2);
        } elseif ($aksi == 'hapus') {
            $abc->hapus_pengguna($id);
        }
        // hapus variable dari memory
        unset($postdata, $data, $data2, $id, $nama, $aksi, $abc);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (($_GET['aksi'] == 'tampil') and (isset($_GET['id']))) {
            $id = $abc->filter($_GET['id']);
        } else  //menampilkan semua data 
        {
            $data = $abc->tampil_semua_pengguna();
            echo json_encode($data);
        }
        unset($postdata, $data, $id, $abc);
    }
