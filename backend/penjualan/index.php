<?php 
session_start(); 
include '../partials/header.php';
include '../../config/koneksi.php';

// Ambil data penjualan dari database dan urutkan dari terbaru ke lama
$sql = "SELECT p.*, m.merk, m.model, u.nama 
        FROM penjualan p 
        JOIN mobil m ON p.id_mobil = m.id_mobil 
        JOIN users u ON p.id_user = u.id
        ORDER BY p.id_penjualan DESC";

$result = mysqli_query($conn, $sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: center;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #2c4f56;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
    select {
        padding: 5px;
        border-radius: 4px;
    }
    .btn-action {
        display: inline-block;
        padding: 6px 10px;
        text-decoration: none;
        color: white;
        border-radius: 4px;
        margin: 2px;
    }
    .btn-detail { background-color: #007bff; }
    .btn-invoice { background-color: #28a745; }
    .btn-transfer { background-color: #6f42c1; } /* Warna ungu untuk bukti transfer */
    .btn-action:hover { opacity: 0.8; }
</style>

<h2 class="text-center my-4">Daftar Penjualan</h2>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if (isset($_SESSION['pesan'])) {
    echo "<script>
        Swal.fire({
            title: '" . $_SESSION['pesan'] . "',
            icon: '" . $_SESSION['pesan_tipe'] . "',
            confirmButtonText: 'OK'
        });
    </script>";
    unset($_SESSION['pesan']);
    unset($_SESSION['pesan_tipe']);
}
?>

<table>
    <tr>
        <th>ID Penjualan</th>
        <th>Pelanggan</th>
        <th>Mobil</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Metode Pembayaran</th>
        <th>DP</th>
        <th>Pengiriman</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id_penjualan'] ?></td> <!-- ID Penjualan tetap asli -->
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['merk'] . ' ' . $row['model']) ?></td>
        <td><?= htmlspecialchars($row['tanggal']) ?></td>
        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
        <td>
            <?= $row['metode_pembayaran'] == 'Cicilan' ? 'Rp ' . number_format($row['dp'], 0, ',', '.') : '-' ?>
        </td>
        <td><?= htmlspecialchars($row['pengiriman']) ?></td>
        <td>
            <form action="update_status.php" method="post">
                <input type="hidden" name="id_penjualan" value="<?= $row['id_penjualan'] ?>">
                <select name="status" onchange="this.form.submit()">
                    <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Diproses" <?= $row['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="Diterima" <?= $row['status'] == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                    <option value="Ditolak" <?= $row['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </form>
        </td>
        <td>
            <a href="detail.php?id=<?= $row['id_penjualan'] ?>" class="btn-action btn-detail" title="Lihat Detail">
                <i class="bi bi-eye-fill"></i> Detail
            </a>
            <a href="invoice.php?id=<?= $row['id_penjualan'] ?>" target="_blank" class="btn-action btn-invoice" title="Lihat Invoice">
                <i class="bi bi-file-earmark-text-fill"></i> Invoice
            </a>
            <?php if ($row['bukti_transfer']) : ?>
                <a href="../../uploads/<?= htmlspecialchars($row['bukti_transfer']) ?>" target="_blank" class="btn-action btn-transfer" title="Lihat Bukti Transfer">
                    <i class="bi bi-receipt"></i> Bukti Transfer
                </a>
            <?php endif; ?>
        </td>
    </tr>
    <?php } ?>
</table>

<?php include '../partials/footer.php'; ?>
