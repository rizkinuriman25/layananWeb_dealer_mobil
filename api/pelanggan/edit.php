<?php  
include '../../config/koneksi.php';

$id = $_GET['id'];

// Ambil data pelanggan
$query = "SELECT u.*, p.nama_pelanggan, p.nik, p.tempat_lahir, p.tanggal_lahir, p.jenis_kelamin 
          FROM users u 
          LEFT JOIN pelanggan p ON u.id = p.id_pelanggan 
          WHERE u.id = $id";
$data = mysqli_query($conn, $query);
$pelanggan = mysqli_fetch_assoc($data);

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $nik = $_POST['nik'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    // Update tabel users
    mysqli_query($conn, "UPDATE users SET 
        nama='$nama', email='$email', no_hp='$no_hp', alamat='$alamat'
        WHERE id = $id");

    // Cek apakah data pelanggan sudah ada di tabel pelanggan
    $cek = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = $id");
    if (mysqli_num_rows($cek) > 0) {
        // Jika sudah ada, update data pelanggan
        mysqli_query($conn, "UPDATE pelanggan SET 
            nama_pelanggan='$nama', nik='$nik', tempat_lahir='$tempat_lahir', 
            tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin'
            WHERE id_pelanggan = $id");
    } else {
        // Jika belum ada, masukkan data baru
        mysqli_query($conn, "INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, nik, tempat_lahir, tanggal_lahir, jenis_kelamin)
            VALUES ($id, '$nama', '$nik', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin')");
    }

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
        --light-bg: #f9f9f9;
        --border-color: #ccc;
        --text-dark: #333;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-dark);
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 30px;
    }

    form {
        max-width: 700px;
        margin: 0 auto;
        background-color: var(--white);
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: var(--primary-color);
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
    }

    hr {
        border: 0;
        height: 1px;
        background-color: #ddd;
        margin: 20px 0;
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

<h2>Edit Data Pelanggan</h2>

<form action="" method="post">
    <label>Nama:</label>
    <input type="text" name="nama" value="<?= $pelanggan['nama'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $pelanggan['email'] ?>" required>

    <label>No HP:</label>
    <input type="text" name="no_hp" value="<?= $pelanggan['no_hp'] ?>">

    <label>Alamat:</label>
    <textarea name="alamat"><?= $pelanggan['alamat'] ?></textarea>

    <hr>

    <label>NIK:</label>
    <input type="text" name="nik" value="<?= $pelanggan['nik'] ?>">

    <label>Tempat Lahir:</label>
    <input type="text" name="tempat_lahir" value="<?= $pelanggan['tempat_lahir'] ?>">

    <label>Tanggal Lahir:</label>
    <input type="date" name="tanggal_lahir" value="<?= $pelanggan['tanggal_lahir'] ?>">

    <label>Jenis Kelamin:</label>
    <select name="jenis_kelamin">
        <option value="L" <?= $pelanggan['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
        <option value="P" <?= $pelanggan['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
    </select>

    <button type="submit" name="submit">Update</button>
</form>

<?php include '../partials/footer.php'; ?>
