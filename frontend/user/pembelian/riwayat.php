<?php
include '../partials/header3.php';
include '../../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user']['id'])) {
    echo "<script>alert('Anda harus login untuk melihat riwayat pembelian!'); window.location='../login.php';</script>";
    exit();
}

$id_user = mysqli_real_escape_string($conn, $_SESSION['user']['id']);
$sql = "SELECT p.*, m.merk, m.model FROM penjualan p
        JOIN mobil m ON p.id_mobil = m.id_mobil
        WHERE p.id_user = '$id_user' ORDER BY p.tanggal DESC";
$result = mysqli_query($conn, $sql);

// Inisialisasi total keseluruhan
$totalKeseluruhan = 0;
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 1200px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px;
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
        background-color: #e9ecef;
    }
    .status {
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 5px;
        display: inline-block;
    }
    .status-pending {
        background-color: #ffc107;
        color: black;
    }
    .status-diproses {
        background-color: #007bff;
        color: white;
    }
    .status-diterima {
        background-color: #28a745;
        color: white;
    }
    .status-ditolak {
        background-color: #dc3545;
        color: white;
    }
    .total-row {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    .bukti-transfer {
        max-width: 80px;
        height: auto;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .bukti-transfer:hover {
        transform: scale(1.5);
    }
</style>

<div class="container">
    <h2>Riwayat Pembelian</h2>
    <div class="table-responsive">
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Mobil</th>
                <th>Metode Pembayaran</th>
                <th>DP</th>
                <th>Total</th>
                <th>Pengiriman</th>
                <th>Bukti Transfer</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php $totalKeseluruhan += $row['total'] + $row['biaya_pengiriman']; ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                    <td><?= htmlspecialchars($row['merk']); ?></td>
                    <td><?= htmlspecialchars($row['metode_pembayaran']); ?></td>
                    <td>Rp <?= number_format($row['dp'] ?? 0, 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($row['pengiriman']); ?></td>
                    <td>
                        <?php if (!empty($row['bukti_transfer'])) : ?>
                            <a href="../../../uploads/<?= htmlspecialchars($row['bukti_transfer']); ?>" target="_blank">
                                <img src="../../../uploads/<?= htmlspecialchars($row['bukti_transfer']); ?>" alt="Bukti Transfer" class="bukti-transfer">
                            </a>
                        <?php else : ?>
                            Tidak ada
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                        $status = htmlspecialchars($row['status']);
                        $statusClass = '';

                        switch ($status) {
                            case 'Pending':
                                $statusClass = 'status-pending';
                                break;
                            case 'Diproses':
                                $statusClass = 'status-diproses';
                                break;
                            case 'Diterima':
                                $statusClass = 'status-diterima';
                                break;
                            case 'Ditolak':
                                $statusClass = 'status-ditolak';
                                break;
                        }
                        ?>
                        <span class="status <?= $statusClass; ?>">
                            <?= $status; ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr class="total-row">
                <td colspan="6">Total Keseluruhan</td>
                <td colspan="3">Rp <?= number_format($totalKeseluruhan, 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>
</div>

<?php include '../partials/footer.php'; ?>