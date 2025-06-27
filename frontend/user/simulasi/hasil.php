<?php include '../partials/header.php'; ?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Simulasi Cicilan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f1f3f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 25px;
        }

        .hasil {
            font-size: 18px;
            font-weight: 600;
            color: #34495e;
            margin: 15px 0;
        }

        .error {
            color: #e74c3c;
            font-weight: 500;
            font-size: 16px;
        }

        button {
            margin-top: 25px;
            padding: 12px 28px;
            background-color: #2c4f56;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1e3a41;
        }

        .info {
            font-size: 14px;
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Cek apakah input tersedia
    if (isset($_POST['harga_mobil'], $_POST['uang_muka'], $_POST['lama_cicilan'])) {
        $harga = floatval($_POST['harga_mobil']);
        $dp = floatval($_POST['uang_muka']);
        $lama = intval($_POST['lama_cicilan']);

        // Tetapkan bunga tetap 3%
        $bunga = 3;

        // Validasi input
        if ($harga <= 0 || $dp < 0 || $lama <= 0) {
            echo "<p class='error'>Masukkan nilai yang valid!</p>";
        } elseif ($dp > $harga) {
            echo "<p class='error'>Uang muka tidak boleh lebih besar dari harga mobil!</p>";
        } else {
            // Perhitungan
            $sisa = $harga - $dp;
            $bunga_total = $sisa * ($bunga / 100);
            $total_cicilan = $sisa + $bunga_total;
            $per_bulan = $total_cicilan / $lama;
            ?>

            <h2>Hasil Simulasi Cicilan</h2>
            <p class="hasil">Harga Mobil: Rp <?= number_format($harga, 0, ',', '.'); ?></p>
            <p class="hasil">Uang Muka: Rp <?= number_format($dp, 0, ',', '.'); ?></p>
            <p class="hasil">Bunga: <?= $bunga; ?>%</p>
            <p class="hasil">Lama Cicilan: <?= $lama; ?> bulan</p>
            <hr style="margin: 20px 0;">
            <p class="hasil">Total Cicilan: <strong>Rp <?= number_format($total_cicilan, 0, ',', '.'); ?></strong></p>
            <p class="hasil">Cicilan Per Bulan: <strong>Rp <?= number_format($per_bulan, 0, ',', '.'); ?></strong></p>

            <p class="info">* Bunga tetap sebesar 3% dari sisa pembayaran setelah DP.</p>

            <?php
        }
    } else {
        echo "<p class='error'>Semua input harus diisi!</p>";
    }
    ?>
    <button onclick="window.history.back()">🔙 Kembali</button>
</div>

</body>
</html>

<?php include '../partials/footer.php'; ?>
