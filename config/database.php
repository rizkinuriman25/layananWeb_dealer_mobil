<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dealer_mobil";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

