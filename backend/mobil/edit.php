<?php 
include '../../config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = $id");
$mobil = mysqli_fetch_assoc($data);

if (isset($_POST['submit'])) {
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $status = $_POST['status'];
    $deskripsi = $_POST['deskripsi'];
    $type_id = $_POST['type_id']; // Menambahkan field type_id

    if ($_FILES['gambar1']['name'] != '') {
        $gambar1 = $_FILES['gambar1']['name'];
        $tmp = $_FILES['gambar1']['tmp_name'];
        move_uploaded_file($tmp, "../../uploads/" . $gambar1);
    } else {
        $gambar1 = $mobil['gambar1'];
    }

    // Mengupdate data mobil termasuk tipe mobil
    $query = "UPDATE mobil SET 
                merk = '$merk', 
                model = '$model', 
                tahun = '$tahun', 
                harga = '$harga',
                stok = '$stok',
                status = '$status',
                deskripsi = '$deskripsi',
                gambar1 = '$gambar1',
                type_id = '$type_id' 
              WHERE id_mobil = $id";
    mysqli_query($conn, $query);

    header("Location: index.php");
    exit;
}
?>

<?php include '../partials/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    :root {
        --primary-color: rgb(44, 79, 86);
        --white: #fff;
        --light-bg: #f1f1f1;
        --border-color: #ccc;
        --text-dark: #333;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-dark);
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 25px;
    }

    form {
        max-width: 700px;
        margin: 0 auto;
        background-color: var(--white);
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        color: var(--primary-color);
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        margin-bottom: 16px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: var(--primary-color);
        color: var(--white);
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #2c4f59;
    }

    @media (max-width: 768px) {
        form {
            padding: 15px;
        }
    }
</style>

<h2>Edit Mobil</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label>Merk:</label>
    <input type="text" name="merk" value="<?= $mobil['merk'] ?>" required>

    <label>Model:</label>
    <input type="text" name="model" value="<?= $mobil['model'] ?>" required>

    <label>Tahun:</label>
    <input type="number" name="tahun" value="<?= $mobil['tahun'] ?>" required>

    <label>Harga:</label>
    <input type="number" name="harga" value="<?= $mobil['harga'] ?>" required>

    <label>Stok:</label>
    <input type="number" name="stok" value="<?= $mobil['stok'] ?>" required>

    <label>Status:</label>
    <select name="status">
        <option value="tersedia" <?= ($mobil['status'] == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
        <option value="tidak tersedia" <?= ($mobil['status'] == 'tidak tersedia') ? 'selected' : '' ?>>Tidak Tersedia</option>
    </select>

    <label>Tipe Mobil:</label>
    <select name="type_id" required>
        <?php 
        // Mengambil data tipe mobil dari database
        $type_query = mysqli_query($conn, "SELECT * FROM type");
        while ($type = mysqli_fetch_assoc($type_query)) {
            $selected = ($mobil['type_id'] == $type['id_type']) ? 'selected' : '';
            echo "<option value='" . $type['id_type'] . "' $selected>" . $type['nama_type'] . "</option>";
        }
        ?>
    </select>

    <label>Deskripsi:</label>
    <textarea name="deskripsi" rows="5"><?= $mobil['deskripsi'] ?></textarea>

    <label>Gambar Utama (jika ingin ganti):</label>
    <input type="file" name="gambar1">

    <button type="submit" name="submit">Update</button>
</form>

<?php include '../partials/footer.php'; ?>
