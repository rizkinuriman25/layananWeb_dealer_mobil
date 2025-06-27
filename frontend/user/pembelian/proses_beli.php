<?php 
session_start();
require_once '../../../config/koneksi.php';

if (!isset($_SESSION['user']['id'])) {
    echo "<script>alert('Anda harus login!'); window.location='../../auth/login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mobil = intval($_POST['id_mobil']);
    $id_user = $_SESSION['user']['id'];
    $tanggal = isset($_POST['tanggal']) ? date('Y-m-d', strtotime($_POST['tanggal'])) : date('Y-m-d'); // Perbaikan tanggal
    $jumlah = intval($_POST['jumlah']);
    $harga_per_unit = floatval($_POST['harga_per_unit']);
    $total = floatval($_POST['total']);
    $metode_pembayaran = isset($_POST['metode']) ? $_POST['metode'] : null; 
    $pengiriman = isset($_POST['pengiriman']) ? $_POST['pengiriman'] : null;
    $dp = isset($_POST['dp']) ? floatval($_POST['dp']) : 0;
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

    // Validasi CSRF token
    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        echo "<script>alert('CSRF token tidak valid!'); window.location='../mobil/list.php';</script>";
        exit();
    }

    // Validasi metode pembayaran
    if (!$metode_pembayaran) {
        echo "<script>alert('Pilih metode pembayaran!'); window.location='../mobil/list.php';</script>";
        exit();
    }

    // Cek stok mobil
    $cek_stok = mysqli_query($conn, "SELECT stok FROM mobil WHERE id_mobil = $id_mobil AND status = 'tersedia'");
    $data_mobil = mysqli_fetch_assoc($cek_stok);
    if (!$data_mobil || $data_mobil['stok'] < $jumlah) {
        echo "<script>alert('Stok tidak mencukupi!'); window.location='../mobil/list.php';</script>";
        exit();
    }

    // Proses upload bukti transfer jika metode pembayaran Transfer
    $bukti_transfer = "";
    if ($metode_pembayaran === "Transfer" && isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        $file_name = time() . "_" . basename($_FILES["bukti"]["name"]);
        $file_path = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Validasi tipe file
        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($file_type, $allowed_types)) {
            echo "<script>alert('Format gambar tidak valid! (Hanya JPG, JPEG, PNG)'); window.location='../mobil/list.php';</script>";
            exit();
        }

        // Simpan file ke folder uploads
        if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $file_path)) {
            $bukti_transfer = $file_name;
        } else {
            echo "<script>alert('Gagal mengupload bukti transfer!'); window.location='../mobil/list.php';</script>";
            exit();
        }
    }

    // Simpan transaksi ke database
    $query = "INSERT INTO penjualan (id_mobil, id_user, tanggal, jumlah, total, metode_pembayaran, dp, bukti_transfer, pengiriman, status, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu Konfirmasi', NOW())";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iisidssss", $id_mobil, $id_user, $tanggal, $jumlah, $total, $metode_pembayaran, $dp, $bukti_transfer, $pengiriman);

    if (mysqli_stmt_execute($stmt)) {
        // Kurangi stok mobil
        mysqli_query($conn, "UPDATE mobil SET stok = stok - $jumlah WHERE id_mobil = $id_mobil");

        echo "<script>alert('Pembelian berhasil! Tunggu konfirmasi admin.'); window.location='../mobil/list.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan!'); window.location='../mobil/list.php';</script>";
    }
}
?>
