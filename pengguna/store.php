<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; // tambahkan logger

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password with bcrypt
$name = $_POST['name'];
$role_id = $_POST['role_id'] ? $_POST['role_id'] : "NULL";

// ================================================================================================
// VALIDASI: Cek username sudah ada atau belum
// ================================================================================================
$checkUsername = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
if (mysqli_num_rows($checkUsername) > 0) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Username sudah digunakan'
    ];
    header('Location: ./create.php');
    exit;
}

// ================================================================================================
// EKSEKUSI INSERT USER BARU
// ================================================================================================

$role_id_sql = $role_id !== "NULL" ? "$role_id" : "NULL";

$query = mysqli_query($connection, "INSERT INTO users(
    username, password, name, role_id
) VALUES(
    '$username', '$password', '$name', $role_id_sql
)");

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil menambah pengguna'
    ];

    // Logging aktivitas
    logActivity('Menambah pengguna', [
        'username' => $username,
        'nama' => $name,
        'role_id' => $role_id !== "NULL" ? $role_id : null
    ]);

    header('Location: ./index.php');
    exit;
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
    header('Location: ./create.php');
    exit;
}
