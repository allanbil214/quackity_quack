<?php
session_start();
require_once 'helper/logger.php'; // tambahkan logger

if (isset($_SESSION['login'])) {
    // Log aktivitas logout
    logActivity('Logout', [
        'user_id' => $_SESSION['login']['id'],
        'username' => $_SESSION['login']['username'],
        'name' => $_SESSION['login']['name'],
        'role_id' => $_SESSION['login']['role_id']
    ]);
}

// Hapus session login
unset($_SESSION['login']);
$_SESSION['login'] = null;

header('Location: login.php');
exit;
