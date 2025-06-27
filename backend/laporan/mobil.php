<?php
include '../partials/header.php';
include '../../config/koneksi.php';

// Query ke database
$result = mysqli_query($conn, "SELECT * FROM mobil");

?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    h2 {
        text-align: center;
        margin-bottom: 3px;
        color: #2c4f56;
    }

    table {
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        margin-bottom: 40px;
    }

    table, th, td {
        border: 1px solid #ccc;
    }

    th, td {
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #2c4f56;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<h2>Laporan Data Mobil</h2>
<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>Merk</th>
            <th>Model</th>
            <th>Tahun</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['merk']); ?></td>
            <td><?= htmlspecialchars($row['model']); ?></td>
            <td><?= htmlspecialchars($row['tahun']); ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?= $row['stok']; ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center;">Tidak ada data mobil tersedia.</p>
<?php endif; ?>

<?php include '../partials/footer.php'; ?>
