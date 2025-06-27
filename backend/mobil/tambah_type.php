<?php
include '../../config/koneksi.php';

if (isset($_POST['submit'])) {
    $nama_type = $_POST['nama_type'];

    // Query untuk menambahkan tipe mobil
    $query = "INSERT INTO type (nama_type) VALUES ('$nama_type')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Tipe Mobil berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan.');</script>";
    }
}
?>

<?php include '../partials/header.php'; ?>

<h2>Tambah Tipe Mobil</h2>

<form action="" method="post">
    <label>Nama Tipe Mobil:</label>
    <input type="text" name="nama_type" required>

    <button type="submit" name="submit">Simpan</button>
</form>

<?php include '../partials/footer.php'; ?>
