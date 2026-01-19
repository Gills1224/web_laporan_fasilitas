<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='login.html';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'];

// ========================
// PARAMETER FILTER
// ========================
$status = $_GET['status'] ?? '';
$jenis  = $_GET['jenis'] ?? '';
$tgl    = $_GET['tgl'] ?? '';

// ========================
// KONDISI WHERE
// ========================
$where = [];

// User hanya lihat laporan sendiri
if ($role !== 'admin') {
    $where[] = "user_id = '$user_id'";
}

// Filter status
if (!empty($status)) {
    $where[] = "status = '$status'";
}

// Filter jenis
if (!empty($jenis)) {
    $where[] = "jenis = '$jenis'";
}

// WHERE SQL
$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

// ========================
// SORT TANGGAL
// ========================
$order = "ORDER BY tanggal DESC";
if ($tgl == 'asc') {
    $order = "ORDER BY tanggal ASC";
}

// ========================
// QUERY
// ========================
$query  = "SELECT * FROM tabel_laporan $whereSQL $order";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Laporan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #eef2f3;
            padding: 20px;
        }

        .header-box {
            background: linear-gradient(135deg, #4b79a1, #283e51);
            padding: 25px;
            border-radius: 12px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            overflow-x: auto;
        }

        .filter-box {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #283e51;
            color: white;
        }

        th, td {
            padding: 10px;
        }

        tbody tr:nth-child(even) {
            background: #f1f1f1;
        }

        img {
            border-radius: 6px;
        }

        .btn-delete {
            background: #d9534f;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 16px;
            background: #283e51;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="header-box">
    <h2>Status Laporan</h2>
    <p><?= $role === 'admin' ? 'Semua laporan' : 'Laporan Anda' ?></p>
</div>

<div class="container">

    <!-- FILTER -->
    <form method="GET" class="filter-box">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Menunggu" <?= $status=='Menunggu'?'selected':'' ?>>Menunggu</option>
            <option value="Diproses" <?= $status=='Diproses'?'selected':'' ?>>Diproses</option>
            <option value="Selesai" <?= $status=='Selesai'?'selected':'' ?>>Selesai</option>
        </select>

        <select name="jenis">
            <option value="">Semua Jenis</option>
            <option value="Kerusakan" <?= $jenis=='Kerusakan'?'selected':'' ?>>Kerusakan</option>
            <option value="Kehilangan" <?= $jenis=='Kehilangan'?'selected':'' ?>>Kehilangan</option>
        </select>

        <select name="tgl">
            <option value="">Tanggal Terbaru</option>
            <option value="asc" <?= $tgl=='asc'?'selected':'' ?>>Tanggal Terlama</option>
        </select>

        <button type="submit">Terapkan</button>
    </form>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Jenis</th>
                <th>Tempat</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Foto</th>
                <th>Tanggal</th>
                <th>Status</th>
                <?php if ($role !== 'admin') { ?>
                    <th>Aksi</th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td><?= $row['tempat'] ?></td>
                <td><?= $row['barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td>
                    <?php if ($row['foto']) { ?>
                        <img src="uploads/<?= $row['foto'] ?>" width="70">
                    <?php } ?>
                </td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['status'] ?></td>

                <?php if ($role !== 'admin') { ?>
                <td>
                    <button class="btn-delete" onclick="hapusLaporan(<?= $row['id'] ?>)">
                        Hapus
                    </button>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <a href="index.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

</div>

<script>
function hapusLaporan(id) {
    Swal.fire({
        title: "Hapus laporan?",
        text: "Data tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d9534f",
        confirmButtonText: "Hapus"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "hapus_laporan_user.php?id=" + id;
        }
    });
}
</script>

</body>
</html>



