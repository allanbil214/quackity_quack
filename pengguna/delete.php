<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; // tambahkan logger

$id = $_GET['id'];

// ================================================================================================
// VALIDATION
// ================================================================================================

// Jangan izinkan hapus akun sendiri
if ($id == $_SESSION['login']['id']) {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Tidak dapat menghapus akun yang sedang digunakan'
  ];
  header('Location: ./index.php');
  exit;
}

// ================================================================================================
// DELETE OPERATIONS
// ================================================================================================

// Ambil data user sebelum dihapus untuk keperluan log
$query = mysqli_query($connection, "SELECT * FROM users WHERE id='$id'");
$userData = mysqli_fetch_assoc($query);

// Hapus user
$deleteQuery = mysqli_query($connection, "DELETE FROM users WHERE id='$id'");
$affected = mysqli_affected_rows($connection);

if ($affected > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus pengguna'
  ];

  // Logging aktivitas
  logActivity('Menghapus pengguna', [
    'id' => $userData['id'],
    'nama' => $userData['nama'] ?? '',
    'username' => $userData['username'] ?? ''
  ]);

  header('Location: ./index.php');
  exit;
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
  exit;
}
