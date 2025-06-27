<?php include '../partials/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    :root {
        --primary-color: rgb(44, 79, 86);
        --white: #ffffff;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c4f56;
        font-family: 'Poppins', sans-serif;
    }

    form {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-family: 'Poppins', sans-serif;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="date"],
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 16px;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    button {
        background-color: #2c4f56;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #1e3a41;
    }

    main {
        flex: 1;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: var(--primary-color);
        color: var(--white);
        font-size: 14px;
        letter-spacing: 0.5px;
        box-shadow: 0 -2px 6px rgba(0,0,0,0.05);
        margin-top: auto;
        font-family: 'Poppins', sans-serif;
    }

    footer p {
        margin: 0;
    }
</style>

<h2>Filter Laporan Penjualan</h2>

<form action="cetak.php" method="GET" target="_blank">
    <label for="dari">Dari Tanggal:</label>
    <input type="date" id="dari" name="dari" required>

    <label for="sampai">Sampai Tanggal:</label>
    <input type="date" id="sampai" name="sampai" required>

    <button type="submit">🖨️ Cetak Laporan</button>
</form>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Dealer Mobil. All rights reserved.</p>
</footer>

</body>
</html>
