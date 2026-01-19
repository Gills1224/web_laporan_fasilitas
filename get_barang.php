<?php
include 'koneksi.php';

$jenis = $_GET['jenis'];

$q = mysqli_query($conn, "
    SELECT id_barang, nama_barang 
    FROM master_barang 
    WHERE jenis_barang = '$jenis'
    ORDER BY nama_barang
");

echo '<option value="">-- Pilih Nama Barang --</option>';

while ($b = mysqli_fetch_assoc($q)) {
    echo "<option value='{$b['id_barang']}'>{$b['nama_barang']}</option>";
}
