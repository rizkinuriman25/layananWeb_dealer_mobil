<?php
include '../config/koneksi.php';

header('Content-Type: application/json');

$id_penjualan = isset($_GET['id']) ? $_GET['id'] : die("ID penjualan diperlukan");

$sql = "SELECT * FROM penjualan WHERE id_penjualan = $id_penjualan";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $penjualan = mysqli_fetch_assoc($result);
    echo json_encode($penjualan);
} else {
    echo json_encode(array("message" => "Penjualan tidak ditemukan"));
}
?>
