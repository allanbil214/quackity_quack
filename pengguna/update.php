<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; // tambahkan logger

$id = $_POST['id'];
$username = $_POST['username'];
$name = $_POST['name'];
$role_id = $_POST['role_id'] ? $_POST['role_id'] : "NULL";

// ================================================================================================
// VALIDASI USERNAME GANDA
// ================================================================================================
$checkUsername = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' AND id != '$id'");
if (mysqli_num_rows($checkUsername) > 0) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Username sudah digunakan'
    ];
    header('Location: ./edit.php?id=' . $id);
    exit;
}

// ================================================================================================
// UPDATE DATA USER
// ================================================================================================

$role_id_sql = $role_id !== "NULL" ? "$role_id" : "NULL";

// Ambil data lama sebelum update untuk log perubahan
$oldQuery = mysqli_query($connection, "SELECT * FROM users WHERE id = '$id'");
$oldData = mysqli_fetch_assoc($oldQuery);

// Cek apakah password diubah
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $sql = "UPDATE users SET 
        username = '$username', 
        password = '$password',
        name = '$name', 
        role_id = $role_id_sql
        WHERE id = '$id'";
} else {
    $sql = "UPDATE users SET 
        username = '$username', 
        name = '$name', 
        role_id = $role_id_sql
        WHERE id = '$id'";
}

$query = mysqli_query($connection, $sql);

if ($query) {
    // Jika user yang diubah adalah user yang sedang login, update session
    if ($_SESSION['login']['id'] == $id) {
        $_SESSION['login']['username'] = $username;
        $_SESSION['login']['name'] = $name;
    }

    // Logging perubahan
    logActivity('Mengubah data pengguna', [
        'id' => $id,
        'before' => [
            'username' => $oldData['username'],
            'name' => $oldData['name'],
            'role_id' => $oldData['role_id']
        ],
        'after' => [
            'username' => $username,
            'name' => $name,
            'role_id' => $role_id !== "NULL" ? $role_id : null
        ],
        'password_changed' => !empty($_POST['password'])
    ]);

    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah data pengguna'
    ];
    header('Location: ./index.php');
    exit;
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
    header('Location: ./edit.php?id=' . $id);
    exit;
}
