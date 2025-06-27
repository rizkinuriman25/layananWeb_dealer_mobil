<?php
include('../../config/koneksi.php');

// Proses form jika dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST['id_user'];
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis_layanan'];
    $biaya = $_POST['biaya'];

    // Gunakan prepared statements untuk keamanan
    $query = "INSERT INTO layanan (id_user, tanggal, jenis_layanan, biaya) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isss", $id_user, $tanggal, $jenis, $biaya);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "<script>alert('Gagal menambahkan layanan!');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<?php include('../partials/header.php'); ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2></i> Tambah Layanan</h2>
        </div>
        <div class="card-body">
            <form method="post" id="layananForm">
                <div class="mb-3">
                    <label for="id_user" class="form-label">Pelanggan</label>
                    <select name="id_user" id="id_user" class="form-select" required>
                        <option value="">Pilih Pelanggan</option>
                        <?php
                        $users = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'");
                        while ($u = mysqli_fetch_assoc($users)) {
                            echo "<option value='{$u['id']}'>{$u['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                    <input type="text" name="jenis_layanan" id="jenis_layanan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya (Rp)</label>
                    <input type="number" name="biaya" id="biaya" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Validasi sebelum submit form
    document.getElementById('layananForm').addEventListener('submit', function(e) {
        let idUser = document.getElementById('id_user').value;
        let tanggal = document.getElementById('tanggal').value;
        let jenis = document.getElementById('jenis_layanan').value;
        let biaya = document.getElementById('biaya').value;

        if (!idUser || !tanggal || !jenis || !biaya) {
            e.preventDefault();
            alert("Harap isi semua data sebelum menyimpan!");
        }
    });
</script>

<?php include('../partials/footer.php'); ?>
