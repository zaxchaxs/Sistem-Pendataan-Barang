<?php
require_once '../config/database.php';
require_once 'barang_functions.php';
session_start();

// Cek ID barang
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$barang = getBarangById($id);

// Jika barang tidak ditemukan
if (!$barang) {
    $_SESSION['alert'] = [
        'message' => 'Barang tidak ditemukan!',
        'type' => 'error'
    ];
    header("Location: index.php");
    exit();
}

// Hapus barang
if (hapusBarang($id)) {
    $_SESSION['alert'] = [
        'message' => 'Barang berhasil dihapus!',
        'type' => 'success'
    ];
} else {
    $_SESSION['alert'] = [
        'message' => 'Gagal menghapus barang!',
        'type' => 'error'
    ];
}

header("Location: index.php");
exit();
