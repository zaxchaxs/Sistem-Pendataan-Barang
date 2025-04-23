<?php
// File: index.php (root folder)
session_start();

// Redirect ke halaman barang jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: barang/index.php");
    exit();
}
// Redirect ke halaman login jika belum login
else {
    header("Location: auth/login.php");
    exit();
}
