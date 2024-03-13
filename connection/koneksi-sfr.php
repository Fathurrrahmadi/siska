<?php
$host = 'localhost'; // atau alamat IP server database
$username = 'root'; // username untuk mengakses database
$password = ''; // password untuk mengakses database
$database = 'siska_a'; // nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

