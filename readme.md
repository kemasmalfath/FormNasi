# 📦 Sistem Donasi Web 

Sistem ini adalah **aplikasi web sederhana** untuk mengelola donasi, dibuat menggunakan **PHP**, **MySQL**, dan **HTML/CSS**. Aplikasi ini memungkinkan pengguna untuk:

- Mengisi formulir donasi secara online.
- Mengunggah bukti transfer atau foto donasi.
- Memilih jumlah donasi dari pilihan yang tersedia atau memasukkan sendiri (seperti Google Form).
- Data disimpan ke database untuk ditampilkan/diakses oleh admin.



## 🗂️ Struktur Folder

```
.
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       ├── script.js
│       └── navigation.js
├── uploads/               # Folder penyimpanan bukti donasi (otomatis dibuat)
├── config/
│   └── database.php       # Koneksi database
├── admin/
│   └── login.php          # Halaman login admin (opsional)
├── rois.jpeg              # Logo aplikasi
├── index.php              # Beranda
├── formulir_donasi.php    # Halaman utama pengisian donasi
├── tentang.php            # Halaman informasi tentang donasi
└── README.md              # Dokumentasi proyek (file ini)
```

---

## 📄 Penjelasan File Penting

### `formulir_donasi.php`
- Halaman utama untuk mengisi donasi.
- Menyediakan pilihan donasi berupa **radio button nominal tetap** atau **input bebas** (opsi "Yang lain").
- Validasi dan upload file bukti transfer.
- Data dikirim dan disimpan ke MySQL.

### `config/database.php`
- File koneksi database, menggunakan PDO.

```php
<?php
$host = 'localhost';
$dbname = 'nama_database';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
```

### `assets/css/style.css`
- Gaya tampilan website.

### `uploads/`
- Tempat file bukti donasi disimpan (dalam `formulir_donasi.php`, folder ini dibuat otomatis jika belum ada).

---

## 📦 Tabel Database `donasi`

Buatlah tabel berikut di MySQL:

```sql
CREATE TABLE donasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100),
    email VARCHAR(100),
    nomor_telepon VARCHAR(20),
    jumlah_donasi INT,
    jenis_donasi VARCHAR(50),
    pesan TEXT,
    bukti_transfer VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## ✅ Cara Menggunakan

1. **Import database**
   - Buat database `donasi_web` atau sesuai kebutuhan.
   - Import struktur tabel seperti di atas.

2. **Atur koneksi**
   - Edit file `config/database.php` sesuai user, password, dan nama database-mu.

3. **Jalankan di server lokal**
   - Gunakan XAMPP/Laragon dan buka `http://localhost/nama-folder/formulir_donasi.php`.

---

## 🧠 Fitur JavaScript

- Aktifkan input “Yang lain” hanya saat dipilih:
```js
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
```

---

## 📬 Kontribusi & Kontak

Proyek ini dikembangkan oleh ROIS FMIPA UNILA sebagai bagian dari sistem digitalisasi donasi.  
Silakan modifikasi dan kembangkan sesuai kebutuhan.

---

## 📌 Catatan Tambahan

- File `admin/login.php` hanya dummy jika tidak digunakan.
- Sistem belum menggunakan autentikasi admin penuh.
- Dapat diperluas menjadi sistem pelaporan & validasi donasi online.

---

## 📄 Lisensi

Open-source project - Bebas digunakan untuk keperluan internal organisasi, edukasi, dan non-komersial.

