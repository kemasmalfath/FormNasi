<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil statistik yang lebih detail dan akurat
$stmt = $pdo->query("SELECT COUNT(*) as total_donasi FROM donasi");
$total_donasi = $stmt->fetch()['total_donasi'];

// Hitung total uang yang sudah diverifikasi dengan format yang benar
$stmt = $pdo->query("SELECT COALESCE(SUM(CAST(jumlah_donasi AS DECIMAL(15,2))), 0) as total_uang FROM donasi WHERE jenis_donasi = 'uang' AND status = 'diverifikasi'");
$total_uang = $stmt->fetch()['total_uang'] ?? 0;

// Pastikan total_uang adalah angka
$total_uang = floatval($total_uang);

$stmt = $pdo->query("SELECT COUNT(*) as pending FROM donasi WHERE status = 'pending'");
$pending = $stmt->fetch()['pending'];

$stmt = $pdo->query("SELECT COUNT(*) as verified FROM donasi WHERE status = 'diverifikasi'");
$verified = $stmt->fetch()['verified'];

$stmt = $pdo->query("SELECT COUNT(*) as total_barang FROM donasi WHERE jenis_donasi = 'barang'");
$total_barang = $stmt->fetch()['total_barang'];

$stmt = $pdo->query("SELECT COUNT(*) as ditolak FROM donasi WHERE status = 'ditolak'");
$ditolak = $stmt->fetch()['ditolak'];

// Ambil data donasi terbaru
$stmt = $pdo->query("SELECT * FROM donasi ORDER BY tanggal_donasi DESC LIMIT 10");
$donasi_terbaru = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="admin-navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <div class="logo-circle" style="width: 40px; height: 40px;">
                    <img src="../rois.jpeg" alt="ROIS FMIPA UNILA Logo" class="logo">
                </div>
                <span style="color: white; font-size: 1.2rem; font-weight: 600; margin-left: 10px;">Admin Panel</span>
            </div>
            <div class="nav-user">
                <span>Halo, <?php echo $_SESSION['admin_nama']; ?></span>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="kelola_donasi.php">Kelola Donasi</a></li>
                <li><a href="ekspor_excel.php">Ekspor Excel</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <p>Selamat datang di panel admin donasi</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($total_donasi); ?></h3>
                        <p>Total Donasi Masuk</p>
                    </div>
                </div>

                <div class="stat-card money-card">
                    <div class="stat-icon money-icon">💰</div>
                    <div class="stat-info">
                        <div class="currency-label">Rp</div>
                        <h3 class="money-amount"><?php echo number_format($total_uang, 0, ',', '.'); ?></h3>
                        <p>Total Uang Terkumpul</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($total_barang); ?></h3>
                        <p>Donasi Barang</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($pending); ?></h3>
                        <p>Menunggu Verifikasi</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($verified); ?></h3>
                        <p>Terverifikasi</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">❌</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($ditolak); ?></h3>
                        <p>Ditolak</p>
                    </div>
                </div>
            </div>

            <div class="recent-donations">
                <h2>Donasi Terbaru</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jumlah</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donasi_terbaru as $donasi): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($donasi['nama_lengkap']); ?></td>
                                <td><?php echo htmlspecialchars($donasi['email']); ?></td>
                                <td>Rp <?php echo number_format($donasi['jumlah_donasi']); ?></td>
                                <td><?php echo ucfirst($donasi['jenis_donasi']); ?></td>
                                <td>
                                    <span class="status status-<?php echo $donasi['status']; ?>">
                                        <?php echo ucfirst($donasi['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($donasi['tanggal_donasi'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
