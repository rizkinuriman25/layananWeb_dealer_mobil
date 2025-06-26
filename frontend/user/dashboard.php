<?php
session_start();
include '../../config/auth_user.php';
include '../../config/koneksi.php';
include 'partials/header1.php';

$id_user = $_SESSION['user']['id'];
$query_beli = "SELECT COUNT(*) as total_beli FROM penjualan WHERE id_user = $id_user";
$result_beli = mysqli_query($conn, $query_beli);
$data_beli = mysqli_fetch_assoc($result_beli);

// Ambil 3 mobil terbaru
$query_mobil = "SELECT * FROM mobil ORDER BY id_mobil DESC LIMIT 3";
$result_mobil = mysqli_query($conn, $query_mobil);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard User - Dealer Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        :root {
            --primary-color: rgb(44, 79, 86);
            --secondary-color: #f5f5f5;
            --white: #ffffff;
            --text-color: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        header,
        footer {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            text-align: center;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        .info-box {
            background: var(--white);
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* List Mobil */
        .mobil-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }

        .mobil-item {
            background-color: var(--white);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .mobil-item:hover {
            transform: translateY(-5px);
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
        }

        .slider-container img {
            width: 140%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .mobil-item h4 {
            margin: 10px 0 5px;
        }

        .harga {
            font-size: 16px;
            font-weight: bold;
            color: darkgreen;
            margin: 10px 0;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px;
            margin-top: 1px;
            margin-bottom: 9px;
        }

        .status.tersedia {
            background-color: #d4edda;
            color: #155724;
        }

        .status.habis {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Tombol */
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-detail {
            display: inline-block;
            padding: 3px 15px;
            font-size: 14px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            background: var(--primary-color);
            transition: background 0.3s ease;
        }

        .btn-detail:hover {
            background-color: #35595f;
        }
    </style>
</head>

<body>

    <main>
        <div class="info-box">
            <h2>Selamat datang, <?= htmlspecialchars($_SESSION['user']['nama']); ?>!</h2>
            <p><i class="bi bi-check-circle"></i> Total pembelian mobil:
                <strong><?= $data_beli['total_beli']; ?></strong></p>
        </div>

        <h3><i class="bi bi-star-fill"></i> Mobil Terbaru</h3>

        <div class="mobil-list">
            <?php while ($mobil = mysqli_fetch_assoc($result_mobil)): ?>
                <div class="mobil-item">
                    <div class="slider-container">
                        <img src="../../uploads/<?= htmlspecialchars($mobil['gambar1']) ?>"
                            alt="<?= htmlspecialchars($mobil['merk']) ?>">
                    </div>
                    <h4><?= htmlspecialchars($mobil['merk']) ?>     <?= htmlspecialchars($mobil['model']) ?>
                        (<?= $mobil['tahun'] ?>)</h4>
                    <p class="harga"><i class="bi bi-cash"></i> Rp <?= number_format($mobil['harga'], 0, ',', '.') ?></p>
                    <span class="status <?= strtolower($mobil['status']) === 'tersedia' ? 'tersedia' : 'habis' ?>">
                        <?= htmlspecialchars($mobil['status']) ?>
                    </span>
                    <div class="btn-group">
                        <a href="../user/mobil/detail.php?id=<?= $mobil['id_mobil'] ?>" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>