-- Script untuk membuat database dan tabel
CREATE DATABASE IF NOT EXISTS formulir_donasi;
USE formulir_donasi;

-- Tabel admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel donasi
CREATE TABLE IF NOT EXISTS donasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nomor_telepon VARCHAR(20) NOT NULL,
    jumlah_donasi DECIMAL(15,2) NOT NULL,
    jenis_donasi ENUM('uang', 'barang', 'lainnya') NOT NULL,
    pesan TEXT,
    bukti_transfer VARCHAR(255),
    tanggal_donasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'diverifikasi', 'ditolak') DEFAULT 'pending'
);

-- Insert admin default (password: admin123)
INSERT INTO admin (username, email, password, nama_lengkap) VALUES 
('admin', 'admin@donasi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');
