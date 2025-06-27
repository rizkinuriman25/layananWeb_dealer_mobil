<?php 
include '../partials/header3.php';
include '../../../config/koneksi.php';

// Mengambil ID mobil yang dipilih dari URL
$id_mobil = isset($_GET['id']) ? $_GET['id'] : '';

// Cek jika ID mobil ada, ambil data mobil dari database
$mobil = null;
if ($id_mobil != '') {
    $query = "SELECT * FROM mobil WHERE id_mobil = '$id_mobil'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $mobil = mysqli_fetch_assoc($result);
    }
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        padding: 20px;
        background-color: rgb(44, 79, 86);
        color: white;
        margin-bottom: 20px;
    }

    form {
        width: 80%;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #45a049;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #36803c;
    }

    .no-result {
        text-align: center;
        color: red;
        font-weight: bold;
    }
</style>

<h2>Simulasi Cicilan Mobil</h2>

<?php if ($mobil): ?>
    <form method="post" action="hasil.php">
        <label>Merk Mobil</label>
        <input type="text" name="merk_mobil" value="<?= htmlspecialchars($mobil['merk']); ?>" readonly>

        <label>Harga Mobil</label>
        <input type="text" value="Rp <?= number_format($mobil['harga'], 0, ',', '.'); ?>" readonly>
        <input type="hidden" name="harga_mobil" value="<?= $mobil['harga']; ?>">

        <label>Uang Muka</label>
        <input type="text" id="uang_muka_display" placeholder="Contoh: Rp 50.000.000" required>
        <input type="hidden" id="uang_muka" name="uang_muka">

        <label>Lama Cicilan (bulan)</label>
        <input type="number" name="lama_cicilan" required>

        <button type="submit">Hitung</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const displayInput = document.getElementById('uang_muka_display');
            const hiddenInput = document.getElementById('uang_muka');

            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function cleanNumber(rupiah) {
                return rupiah.replace(/[^,\d]/g, '').replace(',', '.');
            }

            displayInput.addEventListener('input', function (e) {
                let cleaned = cleanNumber(e.target.value);
                if (cleaned !== '') {
                    displayInput.value = formatRupiah(cleaned);
                    hiddenInput.value = cleaned;
                } else {
                    hiddenInput.value = '';
                }
            });
        });
    </script>
<?php else: ?>
    <p class="no-result">❌ Mobil tidak ditemukan atau terjadi kesalahan.</p>
<?php endif; ?>

<?php include '../partials/footer.php'; ?>
