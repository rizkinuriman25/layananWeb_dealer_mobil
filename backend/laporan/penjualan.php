<?php
include '../partials/header.php';
include '../../config/koneksi.php';

$data = [];
$sql = "SELECT MONTH(tanggal) as bulan, COUNT(*) as total FROM penjualan GROUP BY MONTH(tanggal)";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bulan = date('F', mktime(0, 0, 0, $row['bulan'], 1)); // Konversi angka bulan ke nama bulan
        $data[] = ['bulan' => $bulan, 'total' => $row['total']];
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<!-- Google Fonts (Poppins) --><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">


<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .card-header h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .card-body {
        font-family: 'Poppins', sans-serif;
    }
</style>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2><i class="bi bi-bar-chart-line"></i> Laporan Penjualan per Bulan</h2>
        </div>
        <div class="card-body">
            <canvas id="grafikPenjualan"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikPenjualan').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($data, 'bulan')); ?>,
            datasets: [{
                label: 'Jumlah Penjualan',
                data: <?= json_encode(array_column($data, 'total')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include '../partials/footer.php'; ?>
