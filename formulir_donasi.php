<?php
session_start();
require_once 'config/database.php';

$pesan = '';
$tipe_pesan = '';

if ($_POST) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $jenis_donasi = $_POST['jenis_donasi'];
    $pesan_donatur = $_POST['pesan'];

    // Jumlah donasi dari radio atau input manual
    $jumlah_donasi = ($_POST['jumlah_donasi'] === 'lainnya') ? $_POST['jumlah_donasi_lain'] : $_POST['jumlah_donasi'];

    // Handle file upload
    $bukti_transfer = '';
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['bukti_transfer']['name'], PATHINFO_EXTENSION);
        $new_filename = 'bukti_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $target_file)) {
            $bukti_transfer = $new_filename;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO donasi (nama_lengkap, email, nomor_telepon, jumlah_donasi, jenis_donasi, pesan, bukti_transfer) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama_lengkap, $email, $nomor_telepon, $jumlah_donasi, $jenis_donasi, $pesan_donatur, $bukti_transfer]);

        $pesan = 'Terima kasih! Donasi Anda telah berhasil dikirim dan akan segera diverifikasi.';
        $tipe_pesan = 'success';
    } catch(PDOException $e) {
        $pesan = 'Terjadi kesalahan: ' . $e->getMessage();
        $tipe_pesan = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Donasi</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-weight: bold;
        }
        .form-group input[type="radio"] {
            margin-right: 6px;
        }
        .form-group .radio-wrapper {
            margin-bottom: 6px;
        }
    </style>
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
                <li><a href="index.php" class="nav-link">Beranda</a></li>
                <li><a href="formulir_donasi.php" class="nav-link active">Donasi</a></li>
                <li><a href="tentang.php" class="nav-link">Tentang</a></li>
                <li><a href="admin/login.php" class="nav-link">Admin</a></li>
            </ul>
            <button class="nav-toggle" aria-label="Toggle navigation menu">☰</button>
        </div>
    </nav>

    <main class="form-container">
        <div class="form-wrapper">
            <h2>Formulir Donasi</h2>
            <p class="form-subtitle">Isi formulir di bawah ini untuk melakukan donasi</p>
            
            <?php if ($pesan): ?>
                <div class="alert alert-<?php echo $tipe_pesan; ?>">
                    <?php echo $pesan; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="donation-form">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap *</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon *</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" required>
                </div>

                <div class="form-group">
                    <label>Nominal Komitmen Donasi/Bulan *</label>
                    <div class="radio-wrapper">
                        <label><input type="radio" name="jumlah_donasi" value="10000" required> 10.000</label><br>
                        <label><input type="radio" name="jumlah_donasi" value="15000"> 15.000</label><br>
                        <label><input type="radio" name="jumlah_donasi" value="20000"> 20.000</label><br>
                        <label><input type="radio" name="jumlah_donasi" value="30000"> 30.000</label><br>
                        <label><input type="radio" name="jumlah_donasi" value="40000"> 40.000</label><br>
                        <label><input type="radio" name="jumlah_donasi" value="50000"> 50.000</label><br>
                        <label>
                            <input type="radio" name="jumlah_donasi" value="lainnya" id="donasi_lain_radio"> Yang lain:
                            <input type="number" name="jumlah_donasi_lain" id="donasi_lain_input" min="1000" style="width: 100px;" disabled>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="jenis_donasi">Jenis Donasi *</label>
                    <select id="jenis_donasi" name="jenis_donasi" required>
                        <option value="">Pilih Jenis Donasi</option>
                        <option value="uang">Uang</option>
                        <option value="barang">Barang</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bukti_transfer">Bukti Transfer/Foto Donasi</label>
                    <input type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*,.pdf">
                    <small>Format: JPG, PNG, PDF (Maksimal 5MB)</small>
                </div>

                <div class="form-group">
                    <label for="pesan">Pesan (Opsional)</label>
                    <textarea id="pesan" name="pesan" rows="4" placeholder="Tulis pesan atau doa Anda..."></textarea>
                </div>

                <button type="submit" class="btn-primary">Kirim Donasi</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Formulir Donasi Kebaikan. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Aktifkan input jika "Yang lain" dipilih
        document.querySelectorAll('input[name="jumlah_donasi"]').forEach((el) => {
            el.addEventListener('change', function () {
                const inputLain = document.getElementById('donasi_lain_input');
                if (this.value === 'lainnya') {
                    inputLain.disabled = false;
                    inputLain.required = true;
                } else {
                    inputLain.disabled = true;
                    inputLain.required = false;
                    inputLain.value = '';
                }
            });
        });
    </script>
</body>
</html>
