<?php
session_start();
require_once '../../../config/koneksi.php';
include '../partials/header.php';

// Pastikan user sudah login
if (!isset($_SESSION['user']['id'])) {
    echo "<script>alert('Anda harus login untuk melakukan pembelian!'); window.location='../../../auth/login.php';</script>";
    exit();
}

if (!isset($_GET['id_mobil']) || !is_numeric($_GET['id_mobil'])) {
    echo "<script>alert('Mobil tidak ditemukan!'); window.location='../mobil/list.php';</script>";
    exit();
}

$id_mobil = intval($_GET['id_mobil']);

// Cek apakah mobil masih tersedia dan stoknya lebih dari 0
$query = "SELECT * FROM mobil WHERE id_mobil = ? AND status = 'tersedia' AND stok > 0";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_mobil);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
    echo "<script>alert('Mobil sudah terjual atau tidak tersedia!'); window.location='../mobil/list.php';</script>";
    exit();
}

// Buat CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }
    h2 {
        text-align: center;
        padding: 20px;
        background-color: #2c4f56;
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
        font-weight: bold;
        margin-top: 10px;
    }
    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 15px;
    }
    button:hover {
        background-color: #45a049;
    }
    .hidden {
        display: none;
    }
</style>

<h2>Form Pembelian</h2>
<form action="proses_beli.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="id_mobil" value="<?= htmlspecialchars($mobil['id_mobil']); ?>">
    <input type="hidden" name="harga_per_unit" value="<?= htmlspecialchars($mobil['harga']); ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    
    <label>Merk:</label>
    <p><?= htmlspecialchars($mobil['merk']); ?></p>
    <label>Model:</label>
    <p><?= htmlspecialchars($mobil['model']); ?></p>
    <label>Harga per unit:</label>
    <p>Rp <span id="harga"><?= number_format($mobil['harga']); ?></span></p>
    <label>Stok Tersisa:</label>
    <p><?= htmlspecialchars($mobil['stok']); ?> unit</p>

    <label for="jumlah">Jumlah unit yang dibeli:</label>
    <input type="number" id="jumlah" name="jumlah" min="1" max="<?= htmlspecialchars($mobil['stok']); ?>" value="1" required oninput="updateTotal()">
    
    <label>Total Harga:</label>
    <p>Rp <span id="total"><?= number_format($mobil['harga']); ?></span></p>
    <input type="hidden" name="total" id="total_input" value="<?= htmlspecialchars($mobil['harga']); ?>">

    <label for="metode">Metode Pembayaran:</label>
    <select name="metode" id="metode" required onchange="togglePaymentFields()">
        <option value="">-- Pilih Metode Pembayaran --</option>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="Kredit">Kredit</option>
    </select>

    <div id="kredit_section" class="hidden">
        <label for="dp">Jumlah DP:</label>
        <input type="number" id="dp" name="dp" min="0" placeholder="Masukkan DP">
    </div>

    <div id="transfer_section" class="hidden">
        <label>No. Rekening Dealer:</label>
        <p>123-456-789 (Bank XYZ)</p>
        <label for="bukti">Upload Bukti Transfer:</label>
        <input type="file" id="bukti" name="bukti" accept="image/*">
    </div>

    <label for="pengiriman">Pilih Opsi pengiriman:</label>
    <select name="pengiriman" id="pengiriman" required>
        <option value="">-- Pilih Opsi --</option>
        <option value="Diantar">Diantar</option>
        <option value="Dijemput">Dijemput</option>
    </select>

    <button type="submit" name="submit">Konfirmasi Pembelian</button>
</form>

<script>
function updateTotal() {
    let harga = <?= (int)$mobil['harga']; ?>;
    let jumlah = document.getElementById('jumlah').value;
    let total = harga * jumlah;
    
    document.getElementById('total').innerText = new Intl.NumberFormat('id-ID').format(total);
    document.getElementById('total_input').value = total;
}

function togglePaymentFields() {
    let metode = document.getElementById('metode').value;
    document.getElementById('kredit_section').style.display = metode === 'Kredit' ? 'block' : 'none';
    document.getElementById('transfer_section').style.display = metode === 'Transfer' ? 'block' : 'none';
}

function validateForm() {
    let jumlah = document.getElementById('jumlah').value;
    let stok = <?= (int)$mobil['stok']; ?>;
    let metode = document.getElementById('metode').value;
    let dp = document.getElementById('dp').value;
    let bukti = document.getElementById('bukti').value;
    let pengiriman = document.getElementById('pengiriman').value;
    
    if (jumlah < 1 || jumlah > stok) {
        alert("Jumlah pembelian tidak valid!");
        return false;
    }
    
    if (metode === "Transfer" && bukti === "") {
        alert("Silakan upload bukti pembayaran!");
        return false;
    }
    
    if (pengiriman === "") {
        alert("Pilih opsi pengambilan mobil!");
        return false;
    }
    
    return true;
}
</script>
<?php include '../partials/footer.php'; ?>
