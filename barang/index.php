<?php
require_once '../config/database.php';
require_once 'barang_functions.php';
include_once '../includes/header.php';

// Mendapatkan semua data barang
$barang_list = getAllBarang();

$alert = '';
$alert_type = '';

if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert']['message'];
    $alert_type = $_SESSION['alert']['type'];
    unset($_SESSION['alert']);
}
?>

<div class="bg-white p-6 rounded-lg shadow-md min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Barang</h1>
        <a href="tambah.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Barang
        </a>
    </div>

    <?php if ($alert): ?>
        <div class="<?php echo $alert_type == 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'; ?> border-l-4 p-4 mb-4" role="alert">
            <p><?php echo $alert; ?></p>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">No</th>
                    <th class="py-2 px-4 border-b text-left">Kode Barang</th>
                    <th class="py-2 px-4 border-b text-left">Nama Barang</th>
                    <th class="py-2 px-4 border-b text-left">Jenis Barang</th>
                    <th class="py-2 px-4 border-b text-left">Pesan</th>
                    <th class="py-2 px-4 border-b text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($barang_list)): ?>
                    <tr>
                        <td colspan="6" class="py-4 px-4 border-b text-center">Tidak ada data barang</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1;
                    foreach ($barang_list as $barang): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $no++; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($barang['kode_barang']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($barang['nama_barang']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($barang['jenis_barang']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($barang['pesan']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex space-x-2">
                                    <a href="edit.php?id=<?php echo $barang['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-sm">Edit</a>
                                    <a href="hapus.php?id=<?php echo $barang['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>