<?php
include('../partials/header.php');
include('../../config/koneksi.php');

// Pastikan ID tersedia dan aman dari SQL Injection
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID penjualan tidak valid!'); window.location='index.php';</script>";
    exit();
}

$id_penjualan = intval($_GET['id']);

// Ambil informasi penjualan beserta pelanggan dan mobil
$query_penjualan = "
    SELECT p.id_penjualan, p.tanggal, p.metode_pembayaran, p.total, p.status, p.jumlah, 
           p.dp, p.bukti_transfer, p.pengiriman, p.biaya_pengiriman,
           u.nama AS nama_pelanggan, m.merk, m.model, m.harga 
    FROM penjualan p
    JOIN users u ON p.id_user = u.id
    JOIN mobil m ON p.id_mobil = m.id_mobil
    WHERE p.id_penjualan = $id_penjualan";

$result_penjualan = mysqli_query($conn, $query_penjualan);
$penjualan = mysqli_fetch_assoc($result_penjualan);

if (!$penjualan) {
    echo "<script>alert('Penjualan tidak ditemukan!'); window.location='index.php';</script>";
    exit();
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    .container {
        max-width: 700px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .status {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-block;
    }

    .status-pending {
        background-color: #ffc107;
        color: #212529;
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

    .bukti-transfer {
        max-width: 100px;
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
    <h2>Detail Penjualan</h2>

    <div class="detail-item">
        <strong>Nama Pelanggan:</strong> <span><?= htmlspecialchars($penjualan['nama_pelanggan']) ?></span>
    </div>
    <div class="detail-item">
        <strong>Mobil:</strong> <span><?= htmlspecialchars($penjualan['merk'] . ' ' . $penjualan['model']) ?></span>
    </div>
    <div class="detail-item">
        <strong>Harga Satuan:</strong> <span>Rp <?= number_format($penjualan['harga'], 0, ',', '.') ?></span>
    </div>
    <div class="detail-item">
        <strong>Jumlah Unit:</strong> <span><?= $penjualan['jumlah'] ?></span>
    </div>
    <div class="detail-item">
        <strong>Total Harga:</strong> <span>Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></span>
    </div>
    <div class="detail-item">
        <strong>Metode Pembayaran:</strong> <span><?= htmlspecialchars($penjualan['metode_pembayaran']) ?></span>
    </div>
    <div class="detail-item">
        <strong>DP:</strong> <span>Rp <?= number_format($penjualan['dp'] ?? 0, 0, ',', '.') ?></span>
    </div>
    <div class="detail-item">
        <strong>Pengiriman:</strong> <span><?= htmlspecialchars($penjualan['pengiriman']) ?></span>
    </div>
    <div class="detail-item">
        <strong>Biaya Pengiriman:</strong> <span>Rp
            <?= number_format($penjualan['biaya_pengiriman'], 0, ',', '.') ?></span>
    </div>
    <div class="detail-item">
        <strong>Bukti Transfer:</strong>
        <span>
            <?php if (!empty($penjualan['bukti_transfer'])): ?>
                <a href="../../uploads/<?= htmlspecialchars($penjualan['bukti_transfer']); ?>" target="_blank">
                    <img src="../../uploads/<?= htmlspecialchars($penjualan['bukti_transfer']); ?>" alt="Bukti Transfer"
                        class="bukti-transfer">
                </a>
            <?php else: ?>
                Tidak ada
            <?php endif; ?>
        </span>
    </div>
    <div class="detail-item">
        <strong>Status:</strong>
        <?php
        $status = strtolower($penjualan['status']); // Ubah ke huruf kecil untuk mencocokkan kelas CSS
        $status_class = "status-pending"; // Default
        
        if ($status == "diproses") {
            $status_class = "status-diproses";
        } elseif ($status == "diterima") {
            $status_class = "status-diterima";
        } elseif ($status == "ditolak") {
            $status_class = "status-ditolak";
        }
        ?>
        <span class="status <?= $status_class ?>">
            <?= htmlspecialchars(ucwords($penjualan['status'])) ?>
        </span>
    </div>
</div>

<?php include('../partials/footer.php'); ?>