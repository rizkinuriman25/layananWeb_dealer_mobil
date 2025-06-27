<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Dealer Mobil</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: rgb(44, 79, 86);
            --primary-hover: rgb(30, 58, 65);
            --light-bg: #f9f9f9;
            --white: #ffffff;
            --text-dark: #333;
            --border: #ddd;
            --danger: #dc3545;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            position: relative;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            text-align: center;
            font-weight: 600;
        }

        .logout-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logout-btn {
            background-color: var(--danger);
            color: var(--white);
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #bb2d3b;
        }

        nav {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        nav a,
        .dropbtn {
            padding: 10px 16px;
            background-color: var(--white);
            color: var(--primary-color);
            text-decoration: none;
            border: 2px solid var(--primary-color);
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
            min-width: 160px;
            text-align: center;
            cursor: pointer;
        }

        nav a:hover,
        .dropbtn:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--white);
            min-width: 180px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
            z-index: 1;
            border: 1px solid var(--border);
            border-radius: 6px;
            top: 42px;
            left: 0;
        }

        .dropdown-content a {
            color: var(--text-dark);
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        main {
            padding: 30px;
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .card {
            background-color: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--white);
        }

        table th, table td {
            padding: 12px;
            border: 1px solid var(--border);
            text-align: left;
        }

        table th {
            background-color: var(--primary-color);
            color: var(--white);
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dealer Mobil - Admin Panel</h1>
        <div class="logout-container">
            <a href="../logout.php" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <nav>
            <a href="../dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
            <a href="../mobil/index.php"><i class="bi bi-car-front"></i> Mobil</a>
            <a href="../pelanggan/index.php"><i class="bi bi-people"></i> Pelanggan</a>
            <a href="../penjualan/index.php"><i class="bi bi-cart-check"></i> Penjualan</a>
            <a href="../layanan/index.php"><i class="bi bi-tools"></i> Layanan</a>

            <div class="dropdown">
                <button class="dropbtn"><i class="bi bi-graph-up-arrow"></i> Laporan ▾</button>
                <div class="dropdown-content">
                    <a href="../laporan/penjualan.php">Laporan Penjualan</a>
                    <a href="../laporan/mobil.php">Laporan Mobil</a>
                    <a href="../laporan/layanan.php">Laporan Layanan</a>
                    <a href="../laporan/filter_laporan.php">Filter Laporan</a>
                    <a href="../laporan/cetak.php">Cetak</a>
                </div>
            </div>
        </nav>
    </header>
</body>
</html>
