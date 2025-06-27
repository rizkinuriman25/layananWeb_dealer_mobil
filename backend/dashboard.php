<?php
include 'partials/header1.php';
include '../config/database.php';

// Ambil data statistik
$jumlah_mobil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mobil"))['total'];
$stok_mobil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) AS total_stok FROM mobil"))['total_stok'];
$jumlah_penjualan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM penjualan"))['total'];
$jumlah_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pelanggan"))['total'];

// Mobil terlaris
$mobil_terlaris_query = mysqli_query($conn, "
    SELECT m.merk, m.model, SUM(p.jumlah) AS total_terjual
    FROM penjualan p
    JOIN mobil m ON p.id_mobil = m.id_mobil
    WHERE p.status = 'Diterima'
    GROUP BY p.id_mobil
    ORDER BY total_terjual DESC
    LIMIT 1
");
$mobil_terlaris = mysqli_fetch_assoc($mobil_terlaris_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        h3 {
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .small-box {
            flex: 1;
            min-width: 250px;
            color: white;
            border-radius: 10px;
            padding: 20px;
            position: relative;
        }

        .bg-primary { background-color: #007bff; }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #212529; }
        .bg-danger { background-color: #dc3545; }

        .small-box .inner h3 {
            font-size: 28px;
            margin: 0 0 10px;
        }

        .small-box .icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            opacity: 0.2;
        }

        .small-box-footer {
            display: inline-block;
            margin-top: 10px;
            color: inherit;
            text-decoration: none;
            font-weight: bold;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Dashboard</h3>

    <div class="row">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $jumlah_mobil; ?></h3>
                <p>Jumlah Mobil</p>
            </div>
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <a href="mobil/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>

        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $stok_mobil; ?></h3>
                <p>Total Stok Mobil</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
            <a href="mobil/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>

        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $jumlah_penjualan; ?></h3>
                <p>Total Penjualan</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="penjualan/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>

        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $jumlah_pelanggan; ?></h3>
                <p>Jumlah Pelanggan</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="pelanggan/list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="card" style="width: 100%;">
            <div class="card-header">
                <h4>Mobil Terlaris</h4>
            </div>
            <div class="card-body">
                <?php if ($mobil_terlaris): ?>
                    <p><strong><?= $mobil_terlaris['merk']; ?> - <?= $mobil_terlaris['model']; ?></strong></p>
                    <p>Total Terjual: <?= $mobil_terlaris['total_terjual']; ?> unit</p>
                <?php else: ?>
                    <p>Belum ada data penjualan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php include 'partials/footer.php'; ?>