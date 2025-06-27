<?php
include('../../config/koneksi.php');
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST['id_user'];
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis_layanan'];
    $biaya = $_POST['biaya'];

    $query = "UPDATE layanan SET id_user='$id_user', tanggal_pengajuan='$tanggal',
              jenis_layanan='$jenis', biaya='$biaya' WHERE id_layanan=$id";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit;
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM layanan WHERE id_layanan=$id"));
?>

<?php include('../partials/header.php'); ?>

<!-- Bootstrap CSS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2><i class="bi bi-pencil-square"></i> Edit Layanan</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person"></i> Pelanggan</label>
                    <select name="id_user" class="form-select" required>
                        <?php
                        $users = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'");
                        while ($u = mysqli_fetch_assoc($users)) {
                            $selected = $data['id_user'] == $u['id'] ? 'selected' : '';
                            echo "<option value='{$u['id']}' $selected>{$u['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calendar"></i> Tanggal Pengajuan</label>
                    <input type="date" name="tanggal" value="<?= $data['tanggal_pengajuan'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-list-ul"></i> Jenis Layanan</label>
                    <input type="text" name="jenis_layanan" value="<?= $data['jenis_layanan'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-cash-stack"></i> Biaya (Rp)</label>
                    <input type="number" name="biaya" value="<?= $data['biaya'] ?>" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include('../partials/footer.php'); ?>
