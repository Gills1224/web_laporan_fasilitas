<?php
session_start();
include "koneksi.php";
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "nologin"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn, "
    SELECT id, status 
    FROM tabel_laporan 
    WHERE user_id='$user_id'
    ORDER BY id DESC 
    LIMIT 1
");

if (mysqli_num_rows($q) === 0) {
    echo json_encode(["status" => "nolaporan"]);
    exit;
}

$data = mysqli_fetch_assoc($q);

echo json_encode([
    "id" => $data['id'],
    "status" => strtolower($data['status'])
]);

