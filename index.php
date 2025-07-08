<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Donasi - Beranda</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <div class="logo-circle">
                    <img src="rois.jpeg" alt="ROIS FMIPA UNILA Logo" class="logo">
                </div>
                <span class="logo-text">Donasi Kebaikan</span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link active">Beranda</a></li>
                <li><a href="formulir_donasi.php" class="nav-link">Donasi</a></li>
                <li><a href="tentang.php" class="nav-link">Tentang</a></li>
                <li><a href="admin/login.php" class="nav-link">Admin</a></li>
            </ul>
            <button class="nav-toggle" aria-label="Toggle navigation menu">☰</button>
        </div>
    </nav>

    <main class="hero-section">
        <div class="hero-content">
            <h1>FORMULIR DONASI KEBAIKAN</h1>
            <p>Platform donasi untuk membantu sesama dan berbagi kebaikan<br>
            Mari bersama-sama membangun solidaritas dan kepedulian</p>
            <a href="formulir_donasi.php" class="btn-primary">Mulai Berdonasi</a>
        </div>
    </main>

    <section class="info-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <h3>Visi</h3>
                    <p>Menjadi platform donasi terpercaya yang menghubungkan para donatur dengan mereka yang membutuhkan bantuan, serta membangun budaya berbagi dan kepedulian sosial di masyarakat.</p>
                </div>
                <div class="info-card">
                    <h3>Misi</h3>
                    <ol>
                        <li>Menyediakan platform donasi yang mudah, aman, dan transparan</li>
                        <li>Menghubungkan donatur dengan penerima bantuan secara efektif</li>
                        <li>Membangun kepercayaan melalui transparansi dan akuntabilitas</li>
                        <li>Mendorong partisipasi masyarakat dalam kegiatan sosial</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Formulir Donasi Kebaikan. Semua hak dilindungi.</p>
        </div>
    </footer>
    <script src="assets/js/navigation.js"></script>
</body>
</html>
