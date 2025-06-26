<?php 
session_start();
include '../../config/auth_user.php';
include '../../config/koneksi.php';
include 'partials/header.php';

$id_user = $_SESSION['user']['id'];
$query = "SELECT * FROM users WHERE id = $id_user";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        color: #333;
        padding: 20px;
        background-color: rgb(44, 79, 86);
        color: white;
        margin-bottom: 20px;
    }

    table {
        width: 80%;
        max-width: 800px;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: rgb(44, 79, 86);
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: rgb(44, 79, 86);
        color: white;
        position: fixed;
        width: 100%;
        bottom: 0;
    }

</style>

<h2>Profil Saya</h2>
<table>
    <tr><th>Nama</th><td><?= $user['nama']; ?></td></tr>
    <tr><th>Email</th><td><?= $user['email']; ?></td></tr>
    <tr><th>No HP</th><td><?= $user['no_hp']; ?></td></tr>
    <tr><th>Alamat</th><td><?= $user['alamat']; ?></td></tr>
</table>

<?php include 'partials/footer.php'; ?>
