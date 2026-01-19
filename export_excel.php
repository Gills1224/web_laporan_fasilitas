<?php
session_start();
include "koneksi.php";

// Admin only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit("Akses ditolak");
}

// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_fasilitas.xls");

$query = mysqli_query($conn, "
    SELECT id, nama, jenis, tempat, barang, jumlah, status, tanggal 
    FROM tabel_laporan 
    ORDER BY tanggal DESC
");
?>

<table border="1">
    <tr style="background:#ddd;">
        <th>ID</th>
        <th>Nama</th>
        <th>Jenis</th>
        <th>Tempat</th>
        <th>Barang</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['jenis'] ?></td>
        <td><?= $row['tempat'] ?></td>
        <td><?= $row['barang'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['tanggal'] ?></td>
    </tr>
    <?php } ?>
</table>
