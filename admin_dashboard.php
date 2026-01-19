<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit;
}

include "koneksi.php";


$status = $_GET['status'] ?? '';
$jenis  = $_GET['jenis'] ?? '';
$tgl    = $_GET['tgl'] ?? '';
$barang = $_GET['barang'] ?? '';
$tempat = $_GET['tempat'] ?? '';

$where = [];
$order = "ORDER BY id DESC";

// Filter Status
if (!empty($status)) {
    $where[] = "status='$status'";
}

// Filter Jenis
if (!empty($jenis)) {
    $where[] = "jenis='$jenis'";
}

// Filter Tanggal
if (!empty($tanggal)) {
    $where[] = "DATE(tanggal) = '$tanggal'";
}

// Filter Barang
if (!empty($barang)) {
    $barang = mysqli_real_escape_string($conn, $barang);
    $where[] = "LOWER(barang) LIKE LOWER('%$barang%')";
}

// Filter Tempat
if (!empty($tempat)) {
    $tempat = mysqli_real_escape_string($conn, $tempat);
    $where[] = "LOWER(tempat) LIKE LOWER('%$tempat%')";
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT * FROM tabel_laporan $whereSQL $order";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: #f4f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .admin-header {
            background: linear-gradient(90deg, #007bff, #00d4ff);
            padding: 20px;
            color: white;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .content-wrapper {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        table thead {
            background: #007bff;
            color: white;
        }
        table tbody tr:hover {
            background: #f1faff;
        }
        .logout-btn {
            float: right;
        }
    </style>
</head>

<body>
<div class="container mt-4">

    <!-- HEADER -->
    <div class="admin-header">
        <h2><i class="fas fa-user-shield"></i> Dashboard Admin</h2>
        <p>Kelola laporan fasilitas kampus</p>
        <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
    </div>

    <!-- FILTER -->
    <div class="content-wrapper mb-3">
        <form method="GET" class="row g-2">

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="Menunggu" <?= $status=='Menunggu'?'selected':'' ?>>Menunggu</option>
                    <option value="Diproses" <?= $status=='Diproses'?'selected':'' ?>>Diproses</option>
                    <option value="Selesai" <?= $status=='Selesai'?'selected':'' ?>>Selesai</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="jenis" class="form-select">
                    <option value="">-- Semua Jenis --</option>
                    <option value="Kerusakan" <?= $jenis=='Kerusakan'?'selected':'' ?>>Kerusakan</option>
                    <option value="Kehilangan" <?= $jenis=='kehilangan'?'selected':'' ?>>Kehilangan</option>
                </select>
            </div>

             <div class="col-md-2">
        <input type="text" name="tempat" class="form-control"
               placeholder="Cari tempat..."
               value="<?= htmlspecialchars($tempat) ?>">
    </div>

    <div class="col-md-2">
        <input type="text" name="barang" class="form-control"
               placeholder="Cari barang..."
               value="<?= htmlspecialchars($barang) ?>">
    </div>

            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control"
                       value="<?= htmlspecialchars($tanggal) ?>">
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
            </div>



        </form>
    </div>

    <!-- TABLE -->
    <div class="content-wrapper">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Tempat</th>
                    <th>Barang</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
                </thead>

                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['jenis'] ?></td>
                        <td><?= $row['tempat'] ?></td>
                        <td><?= $row['barang'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td>
                            <span class="badge 
                                <?= $row['status']=='Menunggu'?'bg-warning':
                                   ($row['status']=='Diproses'?'bg-primary':'bg-success') ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>

                        <td>
                            <form action="ubah_status.php" method="POST" class="mb-1">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select form-select-sm mb-1">
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                                <button class="btn btn-primary btn-sm w-100">Update</button>
                            </form>

                            <button class="btn btn-danger btn-sm w-100"
                                    onclick="hapusLaporan('<?= $row['id'] ?>')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<div class="mb-3 d-flex gap-2">
    <a href="export_excel.php" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>
</div>


</div>

<script>
function hapusLaporan(id) {
    Swal.fire({
        title: "Hapus Laporan?",
        text: "Data tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Hapus"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("hapus_laporan.php", {
                method: "POST",
                body: new URLSearchParams({id:id})
            })
            .then(() => location.reload());
        }
    });
}
</script>

</body>
</html>



