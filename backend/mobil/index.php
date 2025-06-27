<?php include '../partials/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f5f5f5;
    }

    h2 {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-tambah {
        background-color: #198754;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
    }

    .btn-tambah:hover {
        background-color: #157347;
        color: white;
    }

    .search-form input[type="text"] {
        padding: 8px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 250px;
    }

    .search-form button {
        padding: 8px 14px;
        border: none;
        border-radius: 5px;
        background-color: #0d6efd;
        color: white;
        font-weight: 500;
        cursor: pointer;
    }

    .search-form button:hover {
        background-color: #0b5ed7;
    }

    .table-wrapper {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    table thead {
        background-color: #343a40;
        color: white;
    }

    table th, table td {
        padding: 12px;
        border: 1px solid #ddd;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .btn-edit,
    .btn-delete {
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

    .btn-edit {
        background-color: #0d6efd;
    }

    .btn-edit:hover {
        background-color: #0b5ed7;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #bb2d3b;
    }
</style>

<div class="container">
    <h2>Data Mobil</h2>

    <div class="top-bar">
        <a href="tambah.php" class="btn-tambah">
            <i class="bi bi-plus-circle"></i> Tambah Mobil
        </a>

        <form action="" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari merk, model, atau tahun..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit"><i class="bi bi-search"></i> Cari</button>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Tahun</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            include '../../config/koneksi.php';

            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
            $query = "SELECT * FROM mobil";

            if (!empty($search)) {
                $query .= " WHERE merk LIKE '%$search%' OR model LIKE '%$search%' OR tahun LIKE '%$search%'";
            }

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['merk']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['tahun']}</td>
                        <td>Rp " . number_format($row['harga']) . "</td>
                        <td>{$row['stok']}</td>
                        <td>
                            <div class='action-buttons'>
                                <a href='edit.php?id={$row['id_mobil']}' class='btn-edit' title='Edit'>
                                    <i class='bi bi-pencil-square'></i>
                                </a>
                                <a href='hapus.php?id={$row['id_mobil']}' class='btn-delete' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                    <i class='bi bi-trash'></i>
                                </a>
                            </div>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Data tidak ditemukan.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
