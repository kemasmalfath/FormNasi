<?php
session_start();
require_once '../config/database.php';

$pesan = '';
$tipe_pesan = '';

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO admin (username, email, password, nama_lengkap) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $nama_lengkap]);
        
        $pesan = 'Pendaftaran berhasil! Silakan login.';
        $tipe_pesan = 'success';
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) {
            $pesan = 'Username atau email sudah digunakan!';
        } else {
            $pesan = 'Terjadi kesalahan: ' . $e->getMessage();
        }
        $tipe_pesan = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-wrapper">
            <div class="auth-header">
                <div class="nav-logo" style="justify-content: center; margin-bottom: 1rem;">
                    <div class="logo-circle">
                        <img src="../rois.jpeg" alt="ROIS FMIPA UNILA Logo" class="logo">
                    </div>
                    <span class="logo-text" style="color: #1e3a8a;">Donasi Kebaikan</span>
                </div>
                <h2>Daftar Admin</h2>
                <p>Buat akun admin baru</p>
            </div>
            
            <?php if ($pesan): ?>
                <div class="alert alert-<?php echo $tipe_pesan; ?>">
                    <?php echo $pesan; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-primary">Daftar</button>
            </form>

            <div class="auth-links">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
                <p><a href="../index.php">Kembali ke Beranda</a></p>
            </div>
        </div>
    </div>
</body>
</html>
