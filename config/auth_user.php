<?php
if (session_status() === PHP_SESSION_NONE) 
    session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}
