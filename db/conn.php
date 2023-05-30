<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_news";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
