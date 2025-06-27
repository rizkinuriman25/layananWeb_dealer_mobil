<?php
include '../../config/koneksi.php';

// Mendapatkan data dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data
if (isset($data['merk'], $data['model'], $data['harga'], $data['stok'], $data['status'], $data['gambar1'])) {
    $merk = $data['merk'];
    $model = $data['model'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $status = $data['status'];
    $gambar1 = $data['gambar1'];

    // Menambahkan data mobil ke database
    $sql = "INSERT INTO mobil (merk, model, harga, stok, status, gambar1) 
            VALUES ('$merk', '$model', '$harga', '$stok', '$status', '$gambar1')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array('status' => 'success', 'message' => 'Mobil berhasil ditambahkan.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Gagal menambahkan mobil.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Data tidak lengkap.'));
}
?>
