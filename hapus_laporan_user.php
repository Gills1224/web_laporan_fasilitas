<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = intval($_SESSION['user_id']);

if (!isset($_GET['id'])) {
    header("Location: status_laporan.php?err=invalid");
    exit;
}

$id = intval($_GET['id']);

// Pastikan laporan memang milik user ini
$cek = mysqli_query($conn, "SELECT user_id FROM tabel_laporan WHERE id = '$id'");
if (mysqli_num_rows($cek) == 0) {
    header("Location: status_laporan.php?err=notfound");
    exit;
}

$own = mysqli_fetch_assoc($cek);

if ($own['user_id'] != $user_id) {
    header("Location: status_laporan.php?err=forbidden");
    exit;
}

// Hapus data
mysqli_query($conn, "DELETE FROM tabel_laporan WHERE id = '$id'");

// Redirect dengan status sukses
header("Location: status_laporan.php?success=deleted");
exit;
?>
