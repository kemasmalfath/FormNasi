<?php
session_start();
require_once '../config/database.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$pesan = '';

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_nama'] = $admin['nama_lengkap'];
            header('Location: dashboard.php');
            exit;
        } else {
            $pesan = 'Username/email atau password salah!';
        }
    } catch(PDOException $e) {
        $pesan = 'Terjadi kesalahan: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
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
                <h2>Login Admin</h2>
                <p>Masuk ke panel admin</p>
            </div>
            
            <?php if ($pesan): ?>
                <div class="alert alert-error">
                    <?php echo $pesan; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Username atau Email</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-primary">Login</button>
            </form>

            <div class="auth-links">
                <!-- <p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>-->
                <p><a href="../index.php">Kembali ke Beranda</a></p> 
            </div>
        </div>
    </div>
</body>
</html>
