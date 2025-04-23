<?php
require_once 'auth_functions.php';
session_start();

// Jika sudah login, redirect ke halaman utama
if (isset($_SESSION['user_id'])) {
    header("Location: ../barang/index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } else {
        // Coba login
        if (loginUser($username, $password)) {
            header("Location: ../barang/index.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pendataan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Login</h1>

        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username
                </label>
                <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="username" type="text" name="username" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" name="password" required>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">
                    Login
                </button>
            </div>

            <div class="text-center mt-4">
                <p>Belum punya akun? <a href="register.php" class="text-blue-500 hover:text-blue-700">Register</a></p>
            </div>
        </form>
    </div>
</body>

</html>