<?php
session_start();
include "koneksi.php";

// Hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit();
}

// Hanya admin yang boleh hapus
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    http_response_code(403);
    exit("Akses ditolak");
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $query = "DELETE FROM tabel_laporan WHERE id = $id";
    mysqli_query($conn, $query);

    echo "OK";
}
?>

