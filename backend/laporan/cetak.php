<?php
include '../../config/koneksi.php';

// Ambil tanggal jika ada filter
$dari = isset($_GET['dari']) ? $_GET['dari'] : '';
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : '';

// Query untuk mengambil data penjualan dengan pelanggan
$query = "SELECT p.id_penjualan, p.tanggal, m.merk, m.model, 
                 pel.nama_pelanggan, p.total
          FROM penjualan p
          JOIN mobil m ON p.id_mobil = m.id_mobil
          JOIN pelanggan pel ON p.id_user = pel.id_pelanggan"; 

// Filter berdasarkan tanggal jika ada
if (!empty($dari) && !empty($sampai)) {
    $query .= " WHERE p.tanggal BETWEEN '$dari' AND '$sampai'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 40px;
        }
        h2 {
            text-align: center;
        }
        .info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: left;
        }
        table th {
            background-color: #2c4f56;
            color: white;
        }
        .total {
            font-weight: bold;
        }
        @media print {
            button {
                display: none;
            }
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #2c4f56;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1e3a41;
        }
    </style>
</head>
<body>

    <h2>Laporan Penjualan Dealer Mobil</h2>

    <div class="info">
        <?php if (!empty($dari) && !empty($sampai)): ?>
            <p>Periode: <strong><?= htmlspecialchars($dari) ?> s/d <?= htmlspecialchars($sampai) ?></strong></p>
        <?php else: ?>
            <p><em>Menampilkan semua data penjualan</em></p>
        <?php endif; ?>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Mobil</th>
            <th>Pelanggan</th>
            <th>Total Harga</th>
        </tr>

        <?php
        $grand_total = 0;
        if ($result && mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
                $grand_total += $row['total'];
        ?>
            <tr>
                <td><?= htmlspecialchars($row['id_penjualan']) ?></td>
                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                <td><?= htmlspecialchars($row['merk']) . ' ' . htmlspecialchars($row['model']) ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
        <?php endwhile; ?>
        <tr class="total">
            <td colspan="4" style="text-align: right;">Total Penjualan:</td>
            <td>Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
        </tr>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data penjualan.</td>
            </tr>
        <?php endif; ?>
    </table>

    <button onclick="window.print()">🖨️ Cetak</button>

</body>
</html>
