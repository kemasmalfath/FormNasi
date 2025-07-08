<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['download'])) {
    // Ambil data donasi
    $stmt = $pdo->query("SELECT * FROM donasi ORDER BY tanggal_donasi DESC");
    $data_donasi = $stmt->fetchAll();
    
    // Set header untuk download Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="data_donasi_' . date('Y-m-d') . '.xls"');
    header('Cache-Control: max-age=0');
    
    // Buat tabel HTML untuk Excel
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nama Lengkap</th>';
    echo '<th>Email</th>';
    echo '<th>Nomor Telepon</th>';
    echo '<th>Jumlah Donasi</th>';
    echo '<th>Jenis Donasi</th>';
    echo '<th>Pesan</th>';
    echo '<th>Status</th>';
    echo '<th>Tanggal Donasi</th>';
    echo '</tr>';
    
    foreach ($data_donasi as $donasi) {
        echo '<tr>';
        echo '<td>' . $donasi['id'] . '</td>';
        echo '<td>' . htmlspecialchars($donasi['nama_lengkap']) . '</td>';
        echo '<td>' . htmlspecialchars($donasi['email']) . '</td>';
        echo '<td>' . htmlspecialchars($donasi['nomor_telepon']) . '</td>';
        echo '<td>' . $donasi['jumlah_donasi'] . '</td>';
        echo '<td>' . ucfirst($donasi['jenis_donasi']) . '</td>';
        echo '<td>' . htmlspecialchars($donasi['pesan']) . '</td>';
        echo '<td>' . ucfirst($donasi['status']) . '</td>';
        echo '<td>' . $donasi['tanggal_donasi'] . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Excel - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="admin-navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <span>Admin Panel</span>
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="kelola_donasi.php">Kelola Donasi</a></li>
                <li><a href="ekspor_excel.php" class="active">Ekspor Excel</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div class="admin-header">
                <h1>Ekspor Data ke Excel</h1>
                <p>Download data donasi dalam format Excel</p>
            </div>

            <div class="export-section">
                <div class="export-card">
                    <h3>📊 Ekspor Semua Data Donasi</h3>
                    <p>Download semua data donasi yang tersimpan dalam database ke format Excel (.xls)</p>
                    <a href="?download=1" class="btn-primary">Download Excel</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
