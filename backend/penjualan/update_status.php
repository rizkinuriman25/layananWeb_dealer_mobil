<?php
include '../../config/koneksi.php';
session_start(); // Mulai sesi untuk notifikasi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penjualan = isset($_POST['id_penjualan']) ? intval($_POST['id_penjualan']) : 0;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    if ($id_penjualan > 0 && in_array($status, ['Pending', 'Diproses', 'Diterima', 'Ditolak'])) {
        $sql = "UPDATE penjualan SET status = ? WHERE id_penjualan = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $id_penjualan);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan'] = "Status berhasil diperbarui menjadi: " . $status;
            $_SESSION['pesan_tipe'] = "success";
        } else {
            $_SESSION['pesan'] = "Gagal memperbarui status!";
            $_SESSION['pesan_tipe'] = "error";
        }
    } else {
        $_SESSION['pesan'] = "Data tidak valid!";
        $_SESSION['pesan_tipe'] = "warning";
    }

    // Redirect kembali ke halaman index
    header("Location: index.php");
    exit;
} else {
    $_SESSION['pesan'] = "Akses tidak diizinkan!";
    $_SESSION['pesan_tipe'] = "error";
    header("Location: index.php");
    exit;
}
?>
