<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Sesi login tidak ditemukan. Silakan login ulang.'); window.location='login.html';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user_id'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $tempat = $_POST['tempat'];
    $barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fotoName = time() . "_" . basename($_FILES['foto']['name']);
        $targetFile = $targetDir . $fotoName;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
            $foto = $fotoName;
        }
    }

    $query = "INSERT INTO tabel_laporan 
                (nama, jenis, tempat, barang, jumlah, keterangan, foto, tanggal, status, user_id)
              VALUES 
                ('$nama','$jenis','$tempat','$barang','$jumlah','$keterangan','$foto',NOW(),'Menunggu','$user_id')";

    if (mysqli_query($conn, $query)) {

        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>

        <script>
            // Array kalimat random
            let messages = [
                'Sabar Boss, Gak ada yang instan di dunia ini!',
                'Ditunggu yaa, pakai aja apa yang ada.',
                'Sabar yaa, orang sabar disayang Tuhan.',
                'Kurang-Kurangi bikin laporan, fasilitas kampus gak ada yang murah!.',
            ];

            // Pilih satu secara random
            let randomMsg = messages[Math.floor(Math.random() * messages.length)];

            Swal.fire({
                title: 'Laporan Berhasil Dikirim!',
                text: randomMsg,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location = 'laporan.php';
            });
        </script>

        </body>
        </html>";

        exit();
    } else {
        $errorMsg = mysqli_error($conn);

        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>

        <script>
            Swal.fire({
                title: 'Gagal Menyimpan!',
                text: 'Error: $errorMsg',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.back();
            });
        </script>

        </body>
        </html>";

        exit();
    }
}
?>




