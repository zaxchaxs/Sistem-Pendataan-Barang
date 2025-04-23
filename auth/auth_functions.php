<?php
require_once '../config/database.php';

function registerUser($username, $email, $password)
{
    global $conn;

    // Hash password untuk keamanan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

function loginUser($username, $password)
{
    global $conn;

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }

    return false;
}

function logoutUser()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
