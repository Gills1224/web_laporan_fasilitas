<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.html");
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

$query = mysqli_prepare(
    $conn,
    "SELECT id, username, password, role FROM users WHERE username = ?"
);

mysqli_stmt_bind_param($query, "s", $username);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

if ($user = mysqli_fetch_assoc($result)) {

    if (password_verify($password, $user['password'])) {

        // ======================
        // SET SESSION
        // ======================
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        // ======================
        // SEMUA ROLE KE INDEX
        // ======================
        header("Location: index.php");
        exit;

    } else {
        echo "<script>alert('Password salah!'); window.location='login.html';</script>";
    }

} else {
    echo "<script>alert('Username tidak ditemukan!'); window.location='login.html';</script>";
}

mysqli_stmt_close($query);
mysqli_close($conn);
?>



