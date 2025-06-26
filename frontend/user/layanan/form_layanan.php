<?php
include '../partials/header3.php';
include '../../../config/koneksi.php';
session_start();

// Pastikan session sudah dimulai
if (!isset($_SESSION['user']['id'])) {
    echo "<script>alert('Anda harus login untuk mengajukan layanan!'); window.location='../../login.php';</script>";
    exit();
}

// Ambil id_user dari session
$id_user = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Layanan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        /* Gaya umum untuk halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Container utama */
        h2 {
            text-align: center;
            color: #333;
            padding: 20px 0;
        }

        /* Gaya form */
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Label */
        form label {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        /* Input teks dan textarea */
        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
            height: 150px;
        }

        /* Tombol submit */
        form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        /* Tombol hover */
        form button:hover {
            background-color: #0056b3;
        }

        /* Responsivitas */
        @media screen and (max-width: 768px) {
            form {
                padding: 15px;
            }
            form input[type="text"],
            form textarea {
                font-size: 0.9rem;
            }
            form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<h2>Ajukan Layanan</h2>
<form method="post" action="proses_layanan.php">
    <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user); ?>">
    
    <label>Jenis Layanan</label>
    <input type="text" name="jenis_layanan" required>
    
    <label>Deskripsi</label>
    <textarea name="deskripsi" required></textarea>
    
    <button type="submit">Ajukan</button>
</form>

<?php include '../partials/footer.php'; ?>

</body>
</html>
