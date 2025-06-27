<?php
include '../config/koneksi.php';

header('Content-Type: application/json');

$id_pelanggan = isset($_GET['id']) ? $_GET['id'] : die("ID pelanggan diperlukan");

// Query untuk menghapus pelanggan berdasarkan ID
$sql = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("message" => "Pelanggan berhasil dihapus"));
} else {
    echo json_encode(array("message" => "Terjadi kesalahan"));
}
?>
