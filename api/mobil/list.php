<?php
include '../../config/koneksi.php';

// Mengambil data mobil
$sql = "SELECT * FROM mobil WHERE status = 'tersedia' AND stok > 0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $mobil = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mobil[] = $row;
    }
    // Mengembalikan response dalam format JSON
    echo json_encode(array('status' => 'success', 'data' => $mobil));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Mobil tidak ditemukan.'));
}
?>
