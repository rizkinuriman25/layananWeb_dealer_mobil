<?php include('../partials/header.php'); ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    .btn-action {
        padding: 4px 10px;
        font-size: 0.85rem;
        margin-right: 5px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
    }

    .btn-tambah {
        background-color: #198754;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    .btn-tambah i {
        margin-right: 5px;
    }

    .btn-edit {
        background-color: #0d6efd;
    }

    .btn-edit:hover {
        background-color: #0b5ed7;
    }

    .btn-hapus {
        background-color: #dc3545;
    }

    .btn-hapus:hover {
        background-color: #bb2d3b;
    }

    .btn-action i {
        margin-right: 4px;
    }

    table {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #dee2e6;
    }

    th {
        background-color: #0d6efd;
        color: white;
        padding: 10px;
        text-align: center;
    }

    td {
        padding: 8px;
        vertical-align: middle;
    }
</style>

<h2 class="text-center my-4">Data Layanan Purna Jual</h2>

<div class="container">
    <a href="tambah.php" class="btn-tambah">
        <i class="bi bi-plus-circle-fill"></i> Tambah Layanan
    </a>

    <table>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Tanggal</th>
            <th>Jenis Layanan</th>
            <th>Biaya</th>
            <th>Aksi</th>
        </tr>
        <?php
        include('../../config/koneksi.php');
        $no = 1;
        $query = mysqli_query($conn, "SELECT l.*, u.nama FROM layanan l JOIN users u ON l.id_user = u.id");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?></td>
            <td><?= htmlspecialchars($row['jenis_layanan']) ?></td>
            <td>Rp<?= number_format($row['biaya'], 0, ',', '.') ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_layanan'] ?>" class="btn-action btn-edit" title="Edit">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="hapus.php?id=<?= $row['id_layanan'] ?>" class="btn-action btn-hapus" title="Hapus" onclick="return confirm('Yakin ingin hapus?')">
                    <i class="bi bi-trash-fill"></i> Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include('../partials/footer.php'); ?>
