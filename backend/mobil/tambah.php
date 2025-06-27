<?php
include '../../config/koneksi.php';

if (isset($_POST['submit'])) {
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $status = $_POST['status'];
    $deskripsi = $_POST['deskripsi'];
    $warna1 = $_POST['warna1'];
    $warna2 = $_POST['warna2'];
    $warna3 = $_POST['warna3'];
    $warna4 = $_POST['warna4'];
    $type_id = $_POST['type_id']; // Menangkap nilai type yang dipilih

    // Upload semua gambar
    $gambar1 = uploadFile('gambar1');
    $gambar2 = uploadFile('gambar2');
    $gambar3 = uploadFile('gambar3');
    $gambar4 = uploadFile('gambar4');
    $gambar5 = uploadFile('gambar5');
    $eksterior = uploadFile('eksterior_img');
    $interior = uploadFile('interior_img');
    $keamanan = uploadFile('keamanan_img');
    $performa = uploadFile('performa_img');

    $query = "INSERT INTO mobil 
        (merk, model, tahun, harga, stok, status, deskripsi, warna1, warna2, warna3, warna4, type_id,
         gambar1, gambar2, gambar3, gambar4, gambar5,
         eksterior_img, interior_img, keamanan_img, performa_img)
        VALUES
        ('$merk', '$model', '$tahun', '$harga', '$stok', '$status', '$deskripsi',
         '$warna1', '$warna2', '$warna3', '$warna4', '$type_id',
         '$gambar1', '$gambar2', '$gambar3', '$gambar4', '$gambar5',
         '$eksterior', '$interior', '$keamanan', '$performa')";

    mysqli_query($conn, $query);
    header("Location: index.php");
    exit;
}

function uploadFile($name) {
    $fileName = $_FILES[$name]['name'];
    $tmp = $_FILES[$name]['tmp_name'];
    if ($fileName !== "") {
        move_uploaded_file($tmp, "../../uploads/" . $fileName);
    }
    return $fileName;
}

// Query untuk mengambil semua tipe mobil
$typeQuery = "SELECT * FROM type";
$typeResult = mysqli_query($conn, $typeQuery);
?>

<?php include '../partials/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    :root {
        --primary-color: rgb(44, 79, 86);
        --white: #ffffff;
        --light-bg: #f9f9f9;
        --text-dark: #333;
        --border: #ddd;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--light-bg);
        color: var(--text-dark);
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: var(--primary-color);
        margin-bottom: 20px;
        text-align: center;
    }

    form {
        background-color: var(--white);
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: 0 auto 40px auto;
    }

    label {
        font-weight: 600;
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
        border: 1px solid var(--border);
        border-radius: 6px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: var(--primary-color);
        color: var(--white);
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
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

<h2>Tambah Mobil</h2>

<form action="" method="post" enctype="multipart/form-data">
    <label>Merk:</label>
    <input type="text" name="merk" required>

    <label>Model:</label>
    <input type="text" name="model" required>

    <label>Tahun:</label>
    <input type="number" name="tahun" required>

    <label>Harga:</label>
    <input type="number" name="harga" required>

    <label>Stok:</label>
    <input type="number" name="stok" required>

    <label>Status:</label>
    <select name="status">
        <option value="tersedia">Tersedia</option>
        <option value="tidak tersedia">Tidak Tersedia</option>
    </select>

    <label>Deskripsi:</label>
    <textarea name="deskripsi" rows="5"></textarea>

    <label>Warna 1:</label>
    <input type="text" name="warna1">

    <label>Warna 2:</label>
    <input type="text" name="warna2">

    <label>Warna 3:</label>
    <input type="text" name="warna3">

    <label>Warna 4:</label>
    <input type="text" name="warna4">

    <label>Type Mobil:</label>
    <select name="type_id" required>
        <option value="">Pilih Tipe Mobil</option>
        <?php while ($type = mysqli_fetch_assoc($typeResult)) { ?>
            <option value="<?php echo $type['id_type']; ?>"><?php echo $type['nama_type']; ?></option>
        <?php } ?>
    </select>

    <label>Gambar Utama:</label>
    <input type="file" name="gambar1" required>

    <label>Gambar 2:</label>
    <input type="file" name="gambar2">

    <label>Gambar 3:</label>
    <input type="file" name="gambar3">

    <label>Gambar 4:</label>
    <input type="file" name="gambar4">

    <label>Gambar 5:</label>
    <input type="file" name="gambar5">

    <label>Gambar Eksterior:</label>
    <input type="file" name="eksterior_img">

    <label>Gambar Interior:</label>
    <input type="file" name="interior_img">

    <label>Gambar Keamanan:</label>
    <input type="file" name="keamanan_img">

    <label>Gambar Performa:</label>
    <input type="file" name="performa_img">

    <button type="submit" name="submit">Simpan</button>
</form>

<?php include '../partials/footer.php'; ?>
