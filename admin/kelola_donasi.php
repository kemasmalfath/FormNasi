<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['donasi_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE donasi SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    
    header('Location: kelola_donasi.php');
    exit;
}

// Ambil semua data donasi
$stmt = $pdo->query("SELECT * FROM donasi ORDER BY tanggal_donasi DESC");
$semua_donasi = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Donasi - Admin</title>
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
                <li><a href="kelola_donasi.php" class="active">Kelola Donasi</a></li>
                <li><a href="ekspor_excel.php">Ekspor Excel</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div class="admin-header">
                <h1>Kelola Donasi</h1>
                <p>Verifikasi dan kelola semua donasi yang masuk</p>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Jumlah</th>
                            <th>Jenis</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($semua_donasi as $donasi): ?>
                        <tr>
                            <td><?php echo $donasi['id']; ?></td>
                            <td><?php echo htmlspecialchars($donasi['nama_lengkap']); ?></td>
                            <td><?php echo htmlspecialchars($donasi['email']); ?></td>
                            <td><?php echo htmlspecialchars($donasi['nomor_telepon']); ?></td>
                            <td>Rp <?php echo number_format($donasi['jumlah_donasi']); ?></td>
                            <td><?php echo ucfirst($donasi['jenis_donasi']); ?></td>
                            <td>
                                <?php if ($donasi['bukti_transfer']): ?>
                                    <a href="../uploads/<?php echo $donasi['bukti_transfer']; ?>" target="_blank" class="btn-view">Lihat</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status status-<?php echo $donasi['status']; ?>">
                                    <?php echo ucfirst($donasi['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($donasi['tanggal_donasi'])); ?></td>
                            <td>
                                <form method="POST" class="status-form">
                                    <input type="hidden" name="donasi_id" value="<?php echo $donasi['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $donasi['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="diverifikasi" <?php echo $donasi['status'] == 'diverifikasi' ? 'selected' : ''; ?>>Diverifikasi</option>
                                        <option value="ditolak" <?php echo $donasi['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
