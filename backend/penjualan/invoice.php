<?php
require('../../assets/dompdf/autoload.inc.php');
include('../../config/koneksi.php');

use Dompdf\Dompdf;
use Dompdf\Options;

// Validasi ID penjualan
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}

$id_penjualan = intval($_GET['id']);

// Ambil data penjualan, pelanggan, dan mobil
$query = "
    SELECT p.*, u.nama AS nama_pembeli, u.alamat, u.no_hp, m.merk, m.model 
    FROM penjualan p
    JOIN users u ON p.id_user = u.id
    JOIN mobil m ON p.id_mobil = m.id_mobil
    WHERE p.id_penjualan = $id_penjualan";
$result = mysqli_query($conn, $query);
$penjualan = mysqli_fetch_assoc($result);

if (!$penjualan) {
    die("Data tidak ditemukan.");
}

$nomor_invoice = "INV-" . str_pad($id_penjualan, 6, "0", STR_PAD_LEFT);

// Buffer output HTML
ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Penjualan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        body { font-family: 'Poppins', sans-serif; padding: 20px; }
        .invoice-container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .invoice-header { text-align: center; margin-bottom: 20px; }
        .invoice-header h2 { margin: 0; color: #333; }
        .invoice-body table { width: 100%; border-collapse: collapse; }
        .invoice-body th, .invoice-body td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        .status { padding: 5px 10px; border-radius: 5px; font-weight: bold; display: inline-block; }
        .status-pending { background-color: #ffc107; color: #212529; }
        .status-diproses { background-color: #007bff; color: white; }
        .status-diterima { background-color: #28a745; color: white; }
        .status-ditolak { background-color: #dc3545; color: white; }
        .btn-container { margin-top: 20px; text-align: center; }
        .btn { padding: 10px 15px; text-decoration: none; color: white; background: #007bff; border-radius: 5px; margin: 5px; display: inline-block; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="invoice-container">
    <div class="invoice-header">
        <h2>Invoice Penjualan</h2>
        <p>Nomor Invoice: <?= $nomor_invoice ?></p>
    </div>

    <div class="invoice-body">
        <table>
            <tr><th>Pembeli</th><td><?= htmlspecialchars($penjualan['nama_pembeli']) ?></td></tr>
            <tr><th>Alamat</th><td><?= htmlspecialchars($penjualan['alamat']) ?></td></tr>
            <tr><th>Kontak</th><td><?= htmlspecialchars($penjualan['no_hp']) ?></td></tr>
            <tr><th>Mobil</th><td><?= htmlspecialchars($penjualan['merk'] . ' ' . $penjualan['model']) ?></td></tr>
            <tr><th>Total Harga</th><td>Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></td></tr>
            <tr><th>Status</th>
                <td>
                    <?php 
                        $status = strtolower($penjualan['status']);
                        $status_class = "status-pending"; // Default ke pending

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
                </td>
            </tr>
        </table>
    </div>

    <div class="btn-container">
        <a href="?id=<?= $id_penjualan ?>&download=1" class="btn">📥 Download PDF</a>
        <a href="#" class="btn" onclick="window.print()">🖨 Cetak</a>
    </div>
</div>

</body>
</html>

<?php
$html = ob_get_clean();

// Jika "download" ada di URL, generate PDF
if (isset($_GET['download'])) {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("invoice_$id_penjualan.pdf", ["Attachment" => true]);
    exit();
}

// Jika hanya ingin menampilkan invoice tanpa download, tampilkan HTML
echo $html;
?>
