<?php
include '../partials/header.php';
include '../../config/koneksi.php';

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data layanan purna jual
$query = "SELECT l.*, u.nama FROM layanan l 
          JOIN users u ON l.id_user = u.id 
          ORDER BY l.tanggal_pengajuan DESC";

$result = mysqli_query($conn, $query);

// Periksa jika query gagal
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c4f56;
        font-family: 'Poppins', sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Poppins', sans-serif;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
        font-family: 'Poppins', sans-serif;
    }

    th {
        background-color: #f2f2f2;
    }

    td {
        background-color: #ffffff;
    }
</style>

<h2>Laporan Layanan Purna Jual</h2>

<table>
    <tr>
        <th>Nama Pelanggan</th>
        <th>Jenis Layanan</th>
        <th>Deskripsi</th>
        <th>Tanggal</th>
        <th>Status</th>
    </tr>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['jenis_layanan']); ?></td>
            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
            <td><?= htmlspecialchars($row['tanggal_pengajuan']); ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align: center;">Tidak ada data layanan.</td>
        </tr>
    <?php endif; ?>
</table>

<?php include '../partials/footer.php'; ?>
