<?php
include '../../config/koneksi.php';
session_start();

// Pastikan session sudah dimulai
if (!isset($_SESSION['user']['id'])) {
    echo "<script>alert('Anda harus login untuk mengajukan layanan!'); window.location='../../login.php';</script>";
    exit();
}

// Periksa apakah data sudah ada dalam $_POST
if (!isset($_POST['id_user'], $_POST['jenis_layanan'], $_POST['deskripsi'])) {
    echo "<script>alert('Data tidak lengkap!'); window.location='ajukan_layanan.php';</script>";
    exit();
}

// Ambil data yang dikirimkan dari form
$id_user = $_POST['id_user'];
$jenis_layanan = mysqli_real_escape_string($conn, $_POST['jenis_layanan']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$tanggal_pengajuan = date('Y-m-d H:i:s'); // Menyimpan tanggal saat pengajuan
$status = 'Menunggu'; // Status awal pengajuan

// Query untuk menyimpan data layanan ke database
$query = "INSERT INTO layanan (id_user, jenis_layanan, deskripsi, tanggal_pengajuan, status) 
          VALUES ('$id_user', '$jenis_layanan', '$deskripsi', '$tanggal_pengajuan', '$status')";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Layanan berhasil diajukan!'); window.location='riwayat_layanan.php';</script>";
} else {
    echo "<script>alert('Gagal mengajukan layanan. Silakan coba lagi.'); window.location='ajukan_layanan.php';</script>";
}
?>
