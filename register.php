<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.html");
    exit;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo "
    <script>
        alert('Registrasi berhasil, silakan login');
        window.location='login.html';
    </script>";
} else {
    echo "
    <script>
        alert('Registrasi gagal, username mungkin sudah digunakan');
        window.location='register.html';
    </script>";
}

mysqli_stmt_close($stmt);
?>




