<?php
require_once '../config/database.php';
require_once 'barang_functions.php';
include_once '../includes/header.php';

// Generate kode barang otomatis
$kode_barang = generateKodeBarang();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_barang = trim($_POST['kode_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $jenis_barang = trim($_POST['jenis_barang']);
    $pesan = trim($_POST['pesan']);

    // Validasi input
    if (empty($kode_barang) || empty($nama_barang) || empty($jenis_barang)) {
        $error = "Kode, nama, dan jenis barang harus diisi!";
    } else {
        // Cek kode barang unik
        if (!isKodeBarangUnique($kode_barang)) {
            $error = "Kode barang sudah digunakan!";
        } else {
            if (tambahBarang($kode_barang, $nama_barang, $jenis_barang, $pesan)) {
                $_SESSION['alert'] = [
                    'message' => 'Barang berhasil ditambahkan!',
                    'type' => 'success'
                ];
                header("Location: index.php");
                exit();
            } else {
                $error = "Gagal menambahkan barang. Silakan coba lagi.";
            }
        }
    }
}
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Barang</h1>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <form action="tambah.php" method="post">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_barang">
                Kode Barang
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="kode_barang" type="text" name="kode_barang" value="<?php echo htmlspecialchars($kode_barang); ?>" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_barang">
                Nama Barang
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="nama_barang" type="text" name="nama_barang" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis_barang">
                Jenis Barang
            </label>
            <select class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="jenis_barang" name="jenis_barang" required>
                <option value="">-- Pilih Jenis Barang --</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Pakaian">Pakaian</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Alat Tulis">Alat Tulis</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pesan">
                Pesan
            </label>
            <textarea class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="pesan" name="pesan" rows="4"></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Simpan
            </button>
            <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Kembali
            </a>
        </div>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>