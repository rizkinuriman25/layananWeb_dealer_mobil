<?php 
include 'header1.php';
include '../../config/koneksi.php';

// Ambil parameter model yang dipilih jika ada
$model_filter = "";
if (isset($_GET['model'])) {
    $model_filter = $_GET['model'];
}

// Proses pencarian
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query untuk mengambil data mobil yang tersedia, dengan filter berdasarkan model dan pencarian
$sql = "SELECT m.*, t.nama_type FROM mobil m
        JOIN type t ON m.type_id = t.id_type
        WHERE m.status = 'tersedia' AND m.stok > 0 ";

if ($model_filter != "" && $model_filter != "ALL") {
    $sql .= "AND t.nama_type = '$model_filter' ";
}

if ($search != "") {
    $sql .= "AND (m.merk LIKE '%$search%' OR m.model LIKE '%$search%') ";
}

$result = mysqli_query($conn, $sql);

?>

<h2>Daftar Mobil Tersedia</h2>

<!-- Form Pencarian -->
<form method="GET" class="search-form">
    <input type="text" name="search" placeholder="Cari merk atau model..." value="<?= htmlspecialchars($search); ?>">
    <button type="submit">Cari</button>
</form>

<!-- Kategori Model (Teks Pilihan yang Dapat Diklik) -->
<div class="kategori-model">
    <a href="?model=ALL" class="model <?= ($model_filter == "ALL") ? "active" : ""; ?>">ALL</a>
    <a href="?model=MPV" class="model <?= ($model_filter == "MPV") ? "active" : ""; ?>">MPV</a>
    <a href="?model=Pick-up" class="model <?= ($model_filter == "Pick-up") ? "active" : ""; ?>">Pick-up</a>
    <a href="?model=Hatchback" class="model <?= ($model_filter == "Hatchback") ? "active" : ""; ?>">Hatchback</a>
    <a href="?model=SUV" class="model <?= ($model_filter == "SUV") ? "active" : ""; ?>">SUV</a>
    <a href="?model=Mobil Listrik" class="model <?= ($model_filter == "Mobil Listrik") ? "active" : ""; ?>">Mobil Listrik</a>
    <a href="?model=Crossover" class="model <?= ($model_filter == "Crossover") ? "active" : ""; ?>">Crossover</a>
</div>

<div class="mobil-list">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="mobil-item">
                <div class="slider-container">
                    <div class="slider">
                        <?php 
                        // Menampilkan hanya gambar pertama jika ada
                        if (!empty($row["gambar1"])) {
                            echo "<div class='slide'><img src='../../uploads/" . $row["gambar1"] . "' alt='Gambar Mobil'></div>";
                        }
                        ?>
                    </div>
                </div>
                <h4><?= $row['merk']; ?> - <?= $row['model']; ?> (<?= $row['nama_type']; ?>)</h4> <!-- Menampilkan tipe mobil -->
                <p class="harga">Rp <?= number_format($row['harga']); ?></p>
                <p><strong>Stok:</strong> <?= $row['stok']; ?> unit</p>
                <div class="btn-group">
                    <!-- Tombol Beli mengarah ke form_beli.php -->
                    <a href="../user/pembelian/form_beli.php?id_mobil=<?= $row['id_mobil']; ?>" class="btn beli">Beli</a>
                    
                    <!-- Tombol Cicilan -->
                    <a href="../user/simulasi/index.php?id=<?= $row['id_mobil']; ?>" class="btn cicilan">Cicilan</a>
                    
                    <!-- Tombol Detail -->
                    <a href="detail.php?id=<?= $row['id_mobil']; ?>" class="btn detail">Detail</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-result">❌ Mobil tidak ditemukan atau stok habis.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    
    /* Pencarian */
    .search-form {
        margin-bottom: 20px;
        text-align: center;
    }

    .search-form input {
        padding: 8px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-form button {
        padding: 8px 15px;
        background: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
    }

    /* Kategori Model (Teks Pilihan yang Dapat Diklik) */
    .kategori-model {
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .kategori-model .model {
        margin: 0 5px;
        padding: 6px 12px;
        text-decoration: none;
        color: #007BFF;
        font-weight: 500;
    }

    .kategori-model .model:hover,
    .kategori-model .model.active {
        text-decoration: underline;
        color: #0056b3;
    }

    /* Grid Mobil */
    .mobil-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 20px;
        justify-content: center;
    }

    .mobil-item {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 350px;
        min-height: 400px;
    }

    /* Slider */
    .slider-container {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider {
        display: block;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Harga */
    .harga {
        font-size: 16px;
        font-weight: bold;
        color: black;
        margin: 10px 0;
    }

    /* Tombol */
    .btn-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: auto;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 14px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .beli {
        background: #28a745;
    }

    .beli:hover {
        background: #218838;
    }

    .cicilan {
        background: #ffc107;
    }

    .cicilan:hover {
        background: #e0a800;
    }

    .detail {
        background: #007BFF;
    }

    .detail:hover {
        background: #0056b3;
    }

    /* Jika tidak ada mobil ditemukan */
    .no-result {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        color: red;
        margin-top: 20px;
    }
</style>
