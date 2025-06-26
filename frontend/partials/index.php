<?php include 'header1.php'; ?>
<?php include '../../config/koneksi.php'; // Koneksi ke database ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    
    body {
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        text-align: center;
        color: white;
        padding: 15px;
        background-color: rgb(44, 79, 86);
        width: 600px;
        margin: 0 auto 10px;
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

    select, input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .harga-mobil {
        font-size: 18px;
        font-weight: bold;
        color: #2c4f56;
        margin-bottom: 15px;
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
        background-color: #3d8b40;
    }
</style>

<h2>Simulasi Cicilan Mobil</h2>

<form method="post" action="hasil.php">
    <label>Pilih Mobil</label>
    <select name="harga_mobil" id="harga_mobil" required onchange="tampilkanHarga()">
        <option value="">-- Pilih Mobil --</option>
        <?php
        $query = mysqli_query($conn, "SELECT id_mobil, merk, model, harga FROM mobil ORDER BY merk");
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<option value='{$row['harga']}' data-harga='" . number_format($row['harga'], 0, ',', '.') . "'>{$row['merk']} {$row['model']}</option>";
        }
        ?>
    </select>

    <p class="harga-mobil" id="harga_mobil_display">Harga Mobil: Rp 0</p>

    <label>Uang Muka</label>
    <input type="number" name="uang_muka" required min="0" placeholder="Masukkan uang muka">

    <label>Lama Cicilan (bulan)</label>
    <input type="number" name="lama_cicilan" required min="1" placeholder="Masukkan lama cicilan">

    <!-- Bunga tetap 20% secara otomatis -->
    <input type="hidden" name="bunga" value="20">

    <button type="submit">Hitung</button>
</form>

<script>
    function tampilkanHarga() {
        let selectMobil = document.getElementById("harga_mobil");
        let hargaDisplay = document.getElementById("harga_mobil_display");
        let hargaTerpilih = selectMobil.options[selectMobil.selectedIndex].getAttribute("data-harga");
        
        if (hargaTerpilih) {
            hargaDisplay.innerHTML = "Harga Mobil: Rp " + hargaTerpilih;
        } else {
            hargaDisplay.innerHTML = "Harga Mobil: Rp 0";
        }
    }
</script>

<?php include 'footer.php'; ?>
