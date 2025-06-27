<?php    
include '../../config/koneksi.php';
include '../partials/header.php';

$query = "SELECT u.id, u.nama, u.email, u.no_hp, u.alamat, p.nik, p.tempat_lahir, p.tanggal_lahir, p.jenis_kelamin
          FROM users u 
          LEFT JOIN pelanggan p ON u.id = p.id_pelanggan
          WHERE u.role = 'user'";
$result = mysqli_query($conn, $query);
?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    .btn-action {
        padding: 6px 10px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .btn-action i {
        font-size: 1rem; /* Sama dengan fs-6 */
        vertical-align: middle;
    }

    .btn-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
    }

    .btn-primary:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
    }
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

</style>

<h2 class="text-center my-4">Daftar Pelanggan</h2>

<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>NIK</th>
                <th>TTL</th>
                <th>JK</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['nik']) ?></td>
                    <td><?= htmlspecialchars($row['tempat_lahir']) ?>, <?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                    <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary btn-action" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <!-- Jika ingin tombol hapus juga -->
                        <!-- <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-action" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </a> -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../partials/footer.php'; ?>
