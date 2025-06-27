<?php
include('../../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mobil = $_POST['id_mobil'];
    $id_user = $_POST['id_user'];
    $tanggal = $_POST['tanggal'];
    $metode = $_POST['metode_pembayaran'];
    $total = $_POST['total'];

    $query = "INSERT INTO penjualan (id_mobil, id_user, tanggal, metode_pembayaran, total) 
              VALUES ('$id_mobil', '$id_user', '$tanggal', '$metode', '$total')";
    mysqli_query($conn, $query);

    // Update stok mobil
    mysqli_query($conn, "UPDATE mobil SET stok = stok - 1 WHERE id_mobil = '$id_mobil'");

    header("Location: index.php");
}
?>
<?php include('../partials/header.php'); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<h2>Tambah Penjualan</h2>
<form method="post">
    <label>Mobil</label><br>
    <select name="id_mobil" required>
        <?php
        $mobil = mysqli_query($conn, "SELECT * FROM mobil WHERE stok > 0");
        while($m = mysqli_fetch_assoc($mobil)) {
            echo "<option value='{$m['id_mobil']}'>{$m['merk']} {$m['model']}</option>";
        }
        ?>
    </select><br><br>

    <label>Pelanggan</label><br>
    <select name="id_user" required>
        <?php
        $user = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'");
        while($u = mysqli_fetch_assoc($user)) {
            echo "<option value='{$u['id']}'>{$u['nama']}</option>";
        }
        ?>
    </select><br><br>

    <label>Tanggal</label><br>
    <input type="date" name="tanggal" required><br><br>

    <label>Metode Pembayaran</label><br>
    <input type="text" name="metode_pembayaran" required><br><br>

    <label>Total (Rp)</label><br>
    <input type="number" name="total" required><br><br>

    <button type="submit">Simpan</button>
</form>
<?php include('../partials/footer.php'); ?>
