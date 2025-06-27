<?php
include '../../config/koneksi.php';

// Mendapatkan id mobil dari parameter URL
$id_mobil = isset($_GET['id_mobil']) ? $_GET['id_mobil'] : die(json_encode(array('status' => 'error', 'message' => 'ID mobil diperlukan.')));

// Menghapus data mobil berdasarkan id
$sql = "DELETE FROM mobil WHERE id_mobil = $id_mobil";

if (mysqli_query($conn, $sql)) {
    echo json_encode(array('status' => 'success', 'message' => 'Mobil berhasil dihapus.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus mobil.'));
}
?>
