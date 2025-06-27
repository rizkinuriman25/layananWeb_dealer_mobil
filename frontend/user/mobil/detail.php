<?php
include '../partials/header.php';
include '../../../config/koneksi.php';
$id = $_GET['id'];
$sql = "SELECT * FROM mobil WHERE id_mobil = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    /* Container full width */
    .detail-container {
        width: 100%;
        margin: 0;
        padding: 20px 40px;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Swiper Slider */
    .swiper {
        width: 100%;
        max-width: 1200px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin: auto;
    }
    .swiper-slide img {
    width: 100%;
    max-width: 800px; /* Batasi lebar maksimal */
    height: auto;
    object-fit: contain; /* Pastikan gambar tidak terpotong */
    border-radius: 10px;
    display: block;
    margin: auto; /* Agar gambar tetap di tengah */
}


    .swiper-button-next, .swiper-button-prev {
        color: #2c4f56;
    }

    .info {
        width: 100%;
        padding: 20px;
        background: white;
        border-radius: 8px;
        max-width: 1200px;
        margin: auto;
    }

    .info h3 {
        font-size: 24px;
        text-align: center;
        color: #2c4f56;
        margin-bottom: 5px;
    }

    .info h4 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #3f6a72;
    }

    .info p {
        font-size: 16px;
        line-height: 1.6;
        color: #444;
    }

    .btn-beli {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 24px;
        background-color: #2c4f56;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }

    .btn-beli:hover {
        background-color: #3f6a72;
    }

    h4 {
        margin-top: 30px;
        color: #2c4f56;
        text-align: center;
    }

    /* Fitur Galeri */
    .fitur-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: auto;
    }

    .fitur-item {
        text-align: center;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .fitur-item img {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .fitur-item p {
        font-size: 16px;
        font-weight: bold;
        color: #2c4f56;
        margin: 0;
    }
</style>

<div class="detail-container">
    <!-- Gambar utama (slider) -->
    <div class="swiper main-images">
        <div class="swiper-wrapper">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php if (!empty($row["gambar$i"])): ?>
                    <div class="swiper-slide">
                        <img src="../../../uploads/<?= $row["gambar$i"]; ?>" alt="Gambar <?= $i; ?>">
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <!-- Navigasi slider -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Informasi Mobil -->
    <div class="info">
        <h3><?= $row['merk']; ?></h3>
        <h4><?= $row['model']; ?> (<?= $row['tahun']; ?>)</h4>
        <p><strong>Harga:</strong> Rp <?= number_format($row['harga']); ?></p>
        <p><strong>Status:</strong> <?= $row['status']; ?></p>
        <p><strong>Deskripsi:</strong> <?= $row['deskripsi']; ?></p>
        <p><strong>Warna Tersedia:</strong>
            <?= $row['warna1']; ?>
            <?= !empty($row['warna2']) ? ', ' . $row['warna2'] : ''; ?>
            <?= !empty($row['warna3']) ? ', ' . $row['warna3'] : ''; ?>
            <?= !empty($row['warna4']) ? ', ' . $row['warna4'] : ''; ?>
        </p>
        <a class="btn-beli" href="../../user/pembelian/form_beli.php?id_mobil=<?= $row['id_mobil']; ?>" class="btn beli">Beli</a>
    </div>

    <!-- Gambar Fitur -->
    <h4>Fitur Galeri</h4>
    <div class="fitur-container">
        <?php if (!empty($row['eksterior_img'])): ?>
            <div class="fitur-item">
                <img src="../../../uploads/<?= $row['eksterior_img']; ?>" alt="Eksterior Mobil">
                <p>Eksterior</p>
            </div>
        <?php endif; ?>
        <?php if (!empty($row['interior_img'])): ?>
            <div class="fitur-item">
                <img src="../../../uploads/<?= $row['interior_img']; ?>" alt="Interior Mobil">
                <p>Interior</p>
            </div>
        <?php endif; ?>
        <?php if (!empty($row['keamanan_img'])): ?>
            <div class="fitur-item">
                <img src="../../../uploads/<?= $row['keamanan_img']; ?>" alt="Fitur Keamanan">
                <p>Keamanan</p>
            </div>
        <?php endif; ?>
        <?php if (!empty($row['performa_img'])): ?>
            <div class="fitur-item">
                <img src="../../../uploads/<?= $row['performa_img']; ?>" alt="Performa Mobil">
                <p>Performa</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Swiper JS -->
 
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

<?php include '../partials/footer.php'; ?>
