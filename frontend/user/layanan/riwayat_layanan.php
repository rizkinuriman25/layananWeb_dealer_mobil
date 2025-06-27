<?php
include '../partials/header3.php';
include '../../../config/koneksi.php';
session_start();
$id_user = $_SESSION['user']['id'];

$sql = "SELECT * FROM layanan WHERE id_user = $id_user ORDER BY tanggal_pengajuan DESC";
$result = mysqli_query($conn, $sql);
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    /* Gaya umum untuk halaman */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1400px; /* Memperbesar lebar container */
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        background-color: rgb(44, 79, 86);
        color: white;
        padding: 10px;
        border-radius: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 30px; /* Menambah padding untuk sel tabel */
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: rgb(44, 79, 86);
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .status {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-block;
    }

    .status-lunas {
        background-color: #28a745;
        color: white;
    }

    .status-belum-lunas {
        background-color: #dc3545;
        color: white;
    }

    .total-row {
        font-weight: bold;
        background-color: #f8f9fa;
    }
</style>

<div class="container">
    <h2>Riwayat Layanan</h2>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>Biaya</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                <td><?= htmlspecialchars($row['jenis_layanan']); ?></td>
                <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                <td>Rp <?= number_format($row['biaya'], 0, ',', '.'); ?></td>
                <td>
                    <span class="status <?= $row['status'] == 'Lunas' ? 'status-lunas' : 'status-belum-lunas'; ?>">
                        <?= htmlspecialchars($row['status']); ?>
                    </span>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '../partials/footer.php'; ?>
