<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit;
}

include "koneksi.php";

$id = $_POST['id'];
$status = $_POST['status'];

$query = "UPDATE tabel_laporan SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "si", $status, $id);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Status berhasil diubah!'); window.location='admin_dashboard.php';</script>";
} else {
    echo "<script>alert('Gagal mengubah status!'); window.location='admin_dashboard.php';</script>";
}
?>
