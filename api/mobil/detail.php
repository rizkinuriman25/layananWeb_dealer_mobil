<?php
include '../../config/koneksi.php';

// Mendapatkan id mobil dari parameter URL
$id_mobil = isset($_GET['id_mobil']) ? $_GET['id_mobil'] : die(json_encode(array('status' => 'error', 'message' => 'ID mobil diperlukan.')));

// Mengambil data mobil berdasarkan id
$sql = "SELECT * FROM mobil WHERE id_mobil = $id_mobil";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $mobil = mysqli_fetch_assoc($result);
    echo json_encode(array('status' => 'success', 'data' => $mobil));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Mobil tidak ditemukan.'));
}
?>
