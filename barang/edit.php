<?php
require_once '../config/database.php';
require_once 'barang_functions.php';
include_once '../includes/header.php';

$error = '';
$success = '';
$barang = null;

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_barang = trim($_POST['kode_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $jenis_barang = trim($_POST['jenis_barang']);
    $pesan = trim($_POST['pesan']);

    // Validasi input
    if (empty($kode_barang) || empty($nama_barang) || empty($jenis_barang)) {
        $error = "Kode, nama, dan jenis barang harus diisi!";
    } else {
        // Cek kode barang unik (kecuali untuk ID saat ini)
        if (!isKodeBarangUnique($kode_barang, $id)) {
            $error = "Kode barang sudah digunakan!";
        } else {
            // Update barang
            if (updateBarang($id, $kode_barang, $nama_barang, $jenis_barang, $pesan)) {
                $_SESSION['alert'] = [
                    'message' => 'Barang berhasil diupdate!',
                    'type' => 'success'
                ];
                header("Location: index.php");
                exit();
            } else {
                $error = "Gagal mengupdate barang. Silakan coba lagi.";
            }
        }
    }
}
?>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Barang</h1>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="kode_barang">
                Kode Barang
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="kode_barang" type="text" name="kode_barang" value="<?php echo htmlspecialchars($barang['kode_barang']); ?>" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_barang">
                Nama Barang
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="nama_barang" type="text" name="nama_barang" value="<?php echo htmlspecialchars($barang['nama_barang']); ?>" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis_barang">
                Jenis Barang
            </label>
            <select class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="jenis_barang" name="jenis_barang" required>
                <option value="">-- Pilih Jenis Barang --</option>
                <option value="Elektronik" <?php echo $barang['jenis_barang'] == 'Elektronik' ? 'selected' : ''; ?>>Elektronik</option>
                <option value="Pakaian" <?php echo $barang['jenis_barang'] == 'Pakaian' ? 'selected' : ''; ?>>Pakaian</option>
                <option value="Makanan" <?php echo $barang['jenis_barang'] == 'Makanan' ? 'selected' : ''; ?>>Makanan</option>
                <option value="Minuman" <?php echo $barang['jenis_barang'] == 'Minuman' ? 'selected' : ''; ?>>Minuman</option>
                <option value="Alat Tulis" <?php echo $barang['jenis_barang'] == 'Alat Tulis' ? 'selected' : ''; ?>>Alat Tulis</option>
                <option value="Lainnya" <?php echo $barang['jenis_barang'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pesan">
                Pesan
            </label>
            <textarea class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="pesan" name="pesan" rows="4"><?php echo htmlspecialchars($barang['pesan']); ?></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Update
            </button>
            <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Kembali
            </a>
        </div>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>