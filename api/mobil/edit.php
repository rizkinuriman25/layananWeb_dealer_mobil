<?php
include '../../config/koneksi.php';

// Mendapatkan data dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data
if (isset($data['id_mobil'], $data['merk'], $data['model'], $data['harga'], $data['stok'], $data['status'], $data['gambar1'])) {
    $id_mobil = $data['id_mobil'];
    $merk = $data['merk'];
    $model = $data['model'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $status = $data['status'];
    $gambar1 = $data['gambar1'];

    // Mengupdate data mobil berdasarkan id
    $sql = "UPDATE mobil SET merk = '$merk', model = '$model', harga = '$harga', stok = '$stok', status = '$status', gambar1 = '$gambar1' WHERE id_mobil = $id_mobil";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array('status' => 'success', 'message' => 'Mobil berhasil diperbarui.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Gagal memperbarui mobil.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Data tidak lengkap.'));
}
?>
