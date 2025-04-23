<?php
session_start();

// Cek apakah pengguna sudah login kecuali di halaman login dan register
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'register.php') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pendataan Barang</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold">Sistem Pendataan Barang</div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="flex space-x-4">
                    <a href="../barang/index.php" class="hover:underline">Data Barang</a>
                    <a href="../auth/logout.php" class="hover:underline">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container mx-auto p-4">