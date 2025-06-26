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
            font-family: 'Poppins';
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            text-align: center;
        }

        h2 {
            color: rgb(24, 26, 24);
            font-weight: 600;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        .error {
            color: red;
            font-weight: 500;
        }

        .hasil {
            font-size: 18px;
            font-weight: 600;
            color: rgb(24, 26, 24);
            margin: 10px 0;
        }

        button {
            margin-top: 20px;
            padding: 8px 10px;
            background-color:rgb(231, 48, 48);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        button:hover {
            background-color:rgb(199, 43, 43);
        }

        .back-icon {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if (isset($_POST['harga_mobil'], $_POST['uang_muka'], $_POST['lama_cicilan'], $_POST['bunga'])) {
        $harga = floatval($_POST['harga_mobil']);
        $dp = floatval($_POST['uang_muka']);
        $lama = intval($_POST['lama_cicilan']);
        $bunga = floatval($_POST['bunga']);

        if ($harga <= 0 || $dp < 0 || $lama <= 0 || $bunga < 0) {
            echo "<p class='error'>Masukkan nilai yang valid!</p>";
        } elseif ($dp > $harga) {
            echo "<p class='error'>Uang muka tidak boleh lebih besar dari harga mobil!</p>";
        } else {
            $sisa = $harga - $dp;
            $bunga_total = $sisa * ($bunga / 100);
            $total_cicilan = $sisa + $bunga_total;
            $per_bulan = $total_cicilan / $lama;
            ?>

            <h2>Hasil Simulasi Cicilan</h2>
            <p class="hasil">Harga Mobil: <span style="color:rgb(24, 26, 24);">Rp <?= number_format($harga, 0, ',', '.'); ?></span></p>
            <p class="hasil">Uang Muka: <span style="color:rgb(24, 26, 24);">Rp <?= number_format($dp, 0, ',', '.'); ?></span></p>
            <p class="hasil">Total Cicilan: <span style="color:rgb(24, 26, 24);">Rp <?= number_format($total_cicilan, 0, ',', '.'); ?></span></p>
            <p class="hasil">Cicilan Per Bulan: <span style="color:rgb(24, 26, 24);">Rp <?= number_format($per_bulan, 0, ',', '.'); ?></span></p>

            <?php
        }
    } else {
        echo "<p class='error'>Semua input harus diisi!</p>";
    }
    ?>
    <button onclick="window.history.back()"><span class="back-icon">🔙</span> Kembali</button>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
