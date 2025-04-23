<?php
require_once '../config/database.php';

// Fungsi untuk mendapatkan semua data barang
function getAllBarang()
{
    global $conn;

    $sql = "SELECT * FROM barang ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    $barang = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $barang[] = $row;
        }
    }

    return $barang;
}

// Fungsi untuk mendapatkan satu data barang berdasarkan ID
function getBarangById($id)
{
    global $conn;

    $sql = "SELECT * FROM barang WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}

function tambahBarang($kode_barang, $nama_barang, $jenis_barang, $pesan)
{
    global $conn;

    $sql = "INSERT INTO barang (kode_barang, nama_barang, jenis_barang, pesan) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $kode_barang, $nama_barang, $jenis_barang, $pesan);

    return mysqli_stmt_execute($stmt);
}

function updateBarang($id, $kode_barang, $nama_barang, $jenis_barang, $pesan)
{
    global $conn;

    $sql = "UPDATE barang SET kode_barang = ?, nama_barang = ?, jenis_barang = ?, pesan = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $kode_barang, $nama_barang, $jenis_barang, $pesan, $id);

    return mysqli_stmt_execute($stmt);
}

function hapusBarang($id)
{
    global $conn;

    $sql = "DELETE FROM barang WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}

// Fungsi untuk validasi kode barang unik
function isKodeBarangUnique($kode_barang, $current_id = null)
{
    global $conn;

    if ($current_id) {
        // Jika update, cek kode barang kecuali untuk ID saat ini
        $sql = "SELECT id FROM barang WHERE kode_barang = ? AND id != ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $kode_barang, $current_id);
    } else {
        // Jika tambah baru, cek apakah kode barang sudah ada
        $sql = "SELECT id FROM barang WHERE kode_barang = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $kode_barang);
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    return mysqli_stmt_num_rows($stmt) == 0;
}

// Fungsi untuk generate kode barang otomatis
function generateKodeBarang()
{
    global $conn;

    $prefix = "BRG";
    $sql = "SELECT MAX(id) as max_id FROM barang";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $next_id = ($row['max_id'] ?? 0) + 1;
    return $prefix . str_pad($next_id, 4, '0', STR_PAD_LEFT);
}
