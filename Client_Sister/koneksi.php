<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'admin1';

$conn = mysqli_connect($host, $user, $password, $db);

// Check connection
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
