<?php 
// Cek base path relatif terhadap lokasi file ini
$base_path = dirname($_SERVER['PHP_SELF']) === '/dealer_mobil/user' ? '.' : '..';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel - Dealer Mobil</title>
    <!-- Tambahkan link Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        :root {
            --primary-color: rgb(44, 79, 86);
            --secondary-color: #f5f5f5;
            --white: #ffffff;
            --text-color: #333;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        nav {
            margin-top: 10px;
            position: relative;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
            font-size: 16px;
        }

        nav a i {
            margin-right: 5px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--white);
            min-width: 160px;
            color: rgb(44, 79, 86);
            box-shadow: 0px 8px 16px rgb(44, 79, 86);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: var(--primary-color);
            color: var(--white);
            font-size: 14px;
            letter-spacing: 0.5px;
            box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);
            margin-top: auto;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <header>
        <h1>Dealer Mobil - User Panel</h1>
        <nav>
            <a href="<?= $base_path ?>/user/dashboard.php"><i class="bi bi-speedometer2"></i>Dashboard</a> |
            <a href="<?= $base_path ?>/user/profil.php"><i class="bi bi-person-circle"></i>Profil</a> |
            <a href="<?= $base_path ?>/user/mobil/list.php"><i class="bi bi-car-front"></i>Cari Mobil</a> |
            <a href="<?= $base_path ?>/user/pembelian/riwayat.php"><i class="bi bi-bag-check"></i>Riwayat Pembelian</a> |
            <div class="dropdown">
                <a href="javascript:void(0)"><i class="bi bi-wrench-adjustable-circle"></i>Riwayat Layanan</a>
                <div class="dropdown-content">
                    <a href="<?= $base_path ?>/user/layanan/form_layanan.php">Form Layanan</a>
                    <a href="<?= $base_path ?>/user/layanan/riwayat_layanan.php">Riwayat Layanan</a>
                </div>
            </div>
            <a href="<?= $base_path ?>/user/logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a>
        </nav>
    </header>
</body>
</html>
