<?php
session_start();
include "koneksi.php";

// Cek admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "forbidden"]);
    exit;
}

// Hitung laporan menunggu
$q = mysqli_query($conn, "
    SELECT COUNT(*) AS total, MAX(id) AS latest_id
    FROM tabel_laporan
    WHERE status = 'Menunggu'
");

$data = mysqli_fetch_assoc($q);

echo json_encode([
    "status" => "ok",
    "total" => (int)$data['total'],
    "latest_id" => (int)$data['latest_id']
]);
