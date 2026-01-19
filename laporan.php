<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='login.html';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Laporan Fasilitas Kampus</title>
  <link rel="stylesheet" href="style.css" />

  <!-- Icon Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0088ff, #2de2d3);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: #333;
    }

    /* CARD FORM */
    .form-card {
      width: 100%;
      max-width: 550px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      padding: 25px 30px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
      color: white;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }

    label {
      color: white;
      font-weight: 500;
      margin-top: 15px;
      display: block;
    }

    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
      border: none;
      outline: none;
      border-radius: 10px;
      background: rgba(255,255,255,0.7);
      font-size: 15px;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      background: linear-gradient(90deg, #7b2ff7, #f107a3);
      cursor: pointer;
      transition: 0.2s;
    }

    button:hover {
      transform: scale(1.04);
    }

    .btn-kembali {
      margin-top: 10px;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      background: rgba(0,0,0,0.4);
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-kembali:hover {
      background: rgba(0,0,0,0.6);
      transform: scale(1.04);
    }

    /* Logout button circle */
    .logout-icon {
      display: inline-block;
      background: #dc3545;
      color: white;
      padding: 10px 12px;
      border-radius: 50%;
      font-size: 18px;
      text-decoration: none;
      transition: 0.2s;
      position: absolute;
      top: 20px;
      right: 20px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    }

    .logout-icon:hover {
      background: #b02a37;
      transform: scale(1.1);
    }
  </style>
</head>

<body>

  <!-- Logout Button -->
  <a href="logout.php" class="logout-icon" title="Logout">
    <i class="fas fa-sign-out-alt"></i>
  </a>

  <div class="form-card">

    <h2>Form Laporan Fasilitas Kampus</h2>

    <form id="laporanForm" action="simpan_laporan.php" method="POST" enctype="multipart/form-data">

      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" required />

      <label for="jenis">Jenis Laporan:</label>
      <select id="jenis" name="jenis" required>
        <option value="">-- Pilih Jenis Laporan --</option>
        <option value="Kerusakan">Kerusakan</option>
        <option value="Kehilangan">Kehilangan</option>
      </select>

      <label for="tempat">Tempat Kejadian:</label>
      <input type="text" id="tempat" name="tempat" required />

      <label for="barang">Barang:</label>
      <input type="text" id="barang" name="barang" required />

      <label for="jumlah">Jumlah Barang:</label>
      <input type="number" id="jumlah" name="jumlah" min="1" required />

      <label for="keterangan">Keterangan:</label>
      <textarea id="keterangan" name="keterangan" rows="4" placeholder="Jelaskan kerusakan atau kehilangan..." required></textarea>

      <label for="foto">Upload Bukti (Foto):</label>
      <input type="file" id="foto" name="foto" accept="image/*" required />

      <button type="submit">Kirim Laporan</button>

      <!-- Tombol kembali -->
      <button type="button" class="btn-kembali" onclick="window.location.href='index.php'">
        Kembali ke Halaman Utama
      </button>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>




