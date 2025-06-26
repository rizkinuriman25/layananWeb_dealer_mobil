<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = trim($_POST['email']);

    // Cek apakah email ada di database
    $query = "SELECT id, nama FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nama);
    mysqli_stmt_fetch($stmt);

    if ($id) {
        // Simulasikan pengiriman link reset password (bisa diganti dengan mekanisme sebenarnya)
        $reset_link = "http://yourwebsite.com/reset_password.php?email=" . urlencode($email);
        $message = "Hi $nama, klik link berikut untuk reset password Anda: $reset_link";

        // Kirim email untuk reset password (bisa menggunakan mail() atau PHPMailer)
        // mail($email, "Reset Password", $message);

        $success_message = "Link reset password telah dikirim ke email Anda!";
    } else {
        $error = "Email tidak ditemukan!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .forgot-password-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }

        button {
            padding: 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(7, 64, 126);
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        a {
            color: #0056b3;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="forgot-password-container">
        <h2>Lupa Password</h2>

        <!-- Tampilkan pesan error atau sukses -->
        <?php if (isset($error))
            echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success_message))
            echo "<p class='success'>$success_message</p>"; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <button type="submit" name="forgot_password">Kirim Link Reset Password</button>
        </form>

        <p>Ingat password Anda? <a href="login.php">Login</a></p>
    </div>

</body>

</html>