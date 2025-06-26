<?php include 'partials/header.php'; ?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 800px;
    }

    .card {
        border-radius: 12px;
        border: none;
    }

    h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
    }

    .contact-info li {
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .form-label {
        font-weight: 600;
        color: #555;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
    }

    .btn-primary {
        border-radius: 8px;
        font-weight: bold;
        padding: 10px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div class="container py-5">
    <h1 class="text-center mb-4">Kontak Kami</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="mb-3 text-center">Informasi Kontak</h4>
                <ul class="list-unstyled contact-info">
                    <li><i class="bi bi-geo-alt-fill text-primary fs-5"></i> <strong>Alamat:</strong> Jl. Raya Otomotif
                        No.123, Jakarta</li>
                    <li><i class="bi bi-telephone-fill text-primary fs-5"></i> <strong>Telepon:</strong> 0812-3456-7890
                    </li>
                    <li><i class="bi bi-envelope-fill text-primary fs-5"></i> <strong>Email:</strong>
                        info@dealermobilxyz.com</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="mb-3 text-center">Kirim Pesan</h4>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nama" class="form-label"><i class="bi bi-person-fill"></i> Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Anda"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label"><i class="bi bi-chat-text-fill"></i> Pesan</label>
                        <textarea id="pesan" name="pesan" class="form-control" rows="4" placeholder="Pesan Anda"
                            required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="kirim" class="btn btn-primary"><i class="bi bi-send-fill"></i>
                            Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<?php include 'partials/footer.php'; ?>