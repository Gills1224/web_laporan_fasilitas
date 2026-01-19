<?php
$host = "localhost";      // server
$user = "root";           // default user XAMPP
$pass = "";               // default tanpa password
$db   = "db_laporan";     // nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
