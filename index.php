<?php 
include "header.php"; 
include "koneksi.php"; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Laporan Fasilitas Kampus</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- NOTYF -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <style>
    body {
      background: linear-gradient(135deg, #0088ff, #2de2d3);
      min-height: 100vh;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }

    /* NAVBAR GLASS */
    .navbar {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* GLASS CARD */
    .glass {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }

    .btn-gradient {
      background: linear-gradient(90deg, #7b2ff7, #f107a3);
      border: none;
      color: #fff;
      font-weight: 600;
    }

    .btn-gradient:hover {
      transform: scale(1.07);
    }

    h1, h3, h4 { font-weight: 700; }
  </style>
</head>

<body>

<!-- ========================= NAVBAR ========================= -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="index.php">Sistem Laporan Kampus</a>

    <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#nav">☰</button>

    <div class="collapse navbar-collapse justify-content-end" id="nav">
      <ul class="navbar-nav">
        <?php if (!isset($_SESSION['username'])) { ?>
            <li class="nav-item">
                <a href="login.html" class="btn btn-outline-light me-2">Login</a>
            </li>
            <li class="nav-item">
                <a href="register.html" class="btn btn-gradient">Register</a>
            </li>
        <?php } else { ?>
    <li class="nav-item">
        <span class="nav-link text-white">👤 <?php echo $_SESSION['username']; ?></span>
    </li>

    <?php if ($_SESSION['role'] === 'admin') { ?>
    <li class="nav-item">
        <a href="admin_dashboard.php" class="btn btn-warning me-2">
            📂 Dashboard Admin
        </a>
    </li>
    <?php } ?>

    <li class="nav-item">
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </li>
<?php } ?>

      </ul>
    </div>
  </div>
</nav>


<!-- ========================= HERO ========================= -->
<section class="hero text-center p-5">
  <h1 class="fw-bold">Layanan Pelaporan Fasilitas Kampus</h1>
  <p class="lead">Laporkan masalah fasilitas kampus dengan mudah dan cepat.</p>
</section>


<!-- ========================= FITUR UTAMA ========================= -->
<div class="container mt-4">
  <div class="row g-4">

    <!-- BUAT LAPORAN -->
    <div class="col-md-4">
      <div class="glass p-4 text-center">
        <h3>➕ Buat Laporan</h3>
        <p>Laporkan kerusakan fasilitas kampus dengan cepat.</p>

        <?php if (!isset($_SESSION['username'])) { ?>
            <button onclick="needLogin()" class="btn btn-gradient">Mulai</button>
        <?php } else { ?>
            <?php
$linkLaporan = "laporan.php";
$onclickLaporan = "";

if (!isset($_SESSION['username'])) {
    $linkLaporan = "#";
    $onclickLaporan = "needLogin()";
} elseif ($_SESSION['role'] === 'admin') {
    $linkLaporan = "#";
    $onclickLaporan = "adminRestricted()";
}
?>

<a href="<?= $linkLaporan ?>"
   onclick="<?= $onclickLaporan ?>"
   class="btn btn-gradient">
   Mulai
</a>

        <?php } ?>
      </div>
    </div>

    <!-- STATUS LAPORAN -->
    <div class="col-md-4">
      <div class="glass p-4 text-center">
        <h3>📊 Status Laporan</h3>
        <p>Cek laporan Anda apakah sedang diproses atau sudah selesai.</p>

        <?php if (!isset($_SESSION['username'])) { ?>
            <button onclick="needLogin()" class="btn btn-outline-light">Lihat Status</button>
        <?php } else { ?>
            <?php
$linkStatus = "status_laporan.php";
$onclickStatus = "";

if (!isset($_SESSION['username'])) {
    $linkStatus = "#";
    $onclickStatus = "needLogin()";
} elseif ($_SESSION['role'] === 'admin') {
    $linkStatus = "#";
    $onclickStatus = "adminRestricted()";
}
?>

<a href="<?= $linkStatus ?>"
   onclick="<?= $onclickStatus ?>"
   class="btn btn-outline-light">
   Lihat Status
</a>

        <?php } ?>
      </div>
    </div>

    <!-- PANDUAN -->
    <div class="col-md-4">
      <div class="glass p-4 text-center">
        <h3>📘 Panduan</h3>
        <p>Pahami cara menggunakan sistem laporan fasilitas kampus.</p>
        <a href="panduan.php" class="btn btn-light">Buka Panduan</a>
      </div>
    </div>

  </div>
</div>


<!-- ========================= FOOTER ========================= -->
<footer class="glass text-center p-3 mt-5">
  © 2025 Sarana Prasarana Institut Teknologi Sains Bandung
</footer>


<script>
function needLogin() {
  Swal.fire({
      title: "Ini Siapa Ya??",
      text: "Login dulu lah sobat..",
      icon: "question",
      confirmButtonText: "Login Sekarang",
  }).then((result) => {
      if (result.isConfirmed) {
          window.location = "login.html";
      }
  });
}

function adminRestricted() {
  Swal.fire({
      icon: 'info',
      title: 'Akses Dibatasi',
      text: 'Fitur ini hanya tersedia untuk pengguna biasa.',
      confirmButtonText: 'Mengerti'
  });
}
</script>


<?php if (isset($_SESSION['username'])) { ?>
<script>
  const notyf = new Notyf({
      position: { x: "right", y: "top" },
      duration: 5000,
      dismissible: true
  });

  const notifSound = new Audio("formula-1-radio-notification.mp3");
  notifSound.volume = 0.7;



  // Simpan histori notifikasi per laporan
  let notified = JSON.parse(localStorage.getItem("notifiedLaporan")) || {};

  function cekStatusLaporan() {
      fetch("cek_status.php")
        .then(res => res.json())
        .then(data => {

            if (
              data.status === "nologin" ||
              data.status === "nolaporan" ||
              data.status === "menunggu"
            ) return;

            const laporanId = data.id;
            const status = data.status;

            // Jika laporan & status ini sudah pernah notif → STOP
            if (notified[laporanId] === status) return;

            // Simpan histori
            notified[laporanId] = status;
            localStorage.setItem("notifiedLaporan", JSON.stringify(notified));

            notifSound.play();

            if (status === "diproses") {
                notyf.success("📌 Laporan Anda sedang <b>DIPROSES</b>");
            }

            if (status === "selesai") {
                notyf.success("✅ Laporan Anda telah <b>SELESAI</b> 🎉");
            }
        });
  }

  setInterval(cekStatusLaporan, 5000);
</script>
<?php } ?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
<script>
  const notyfAdmin = new Notyf({
      position: { x: "right", y: "top" },
      duration: 6000,
      dismissible: true
  });

  const adminSound = new Audio("notif.mp3");
  adminSound.volume = 0.7;

  // Simpan waktu login admin
  if (!localStorage.getItem("adminLoginTime")) {
      localStorage.setItem("adminLoginTime", Date.now());
  }

  let lastNotifiedId = localStorage.getItem("lastAdminNotifId") || 0;

  function cekLaporanBaruAdmin() {
      fetch("cek_laporan_baru_admin.php")
        .then(res => res.json())
        .then(data => {

            if (data.status !== "ok") return;

            const latestId = Number(data.latest_id);
            const total = Number(data.total);

            // Tidak ada laporan
            if (total === 0) return;

            // Sudah pernah notif
            if (latestId <= lastNotifiedId) return;

            // Simpan ID terakhir
            localStorage.setItem("lastAdminNotifId", latestId);
            lastNotifiedId = latestId;

            adminSound.play();

            notyfAdmin.success(`🔔 ${total} laporan baru masuk!`);
        });
  }

  // cek tiap 10 detik (lebih aman, tidak spam)
  setInterval(cekLaporanBaruAdmin, 10000);
</script>
<?php } ?>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>






