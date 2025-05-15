<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];

$query = mysqli_query($connection, "SELECT * FROM majalah WHERE id='$id'");
$majalah = mysqli_fetch_assoc($query);

if ($majalah) {
  // Delete the file if it exists
  if (!empty($majalah['file_url']) && file_exists('../' . $majalah['file_url'])) {
    unlink('../' . $majalah['file_url']);
  }

  // Delete the database record
  $deleteQuery = mysqli_query($connection, "DELETE FROM majalah WHERE id='$id'");
  $affected = mysqli_affected_rows($connection); // simpan jumlah baris yang terpengaruh

  // Lakukan SELECT setelah DELETE (jika masih diperlukan)
  $output = [
    'id' => $majalah['id'],
    'judul' => $majalah['judul'],
    'file_url' => $majalah['file_url']
  ];

  if ($affected > 0) {
    $_SESSION['info'] = [
      'status' => 'success',
      'message' => 'Berhasil menghapus majalah'
    ];
    logActivity('Menghapus Majalah', [
      'output' => $output
    ]);
    header('Location: ./index.php');
    exit;
  } else {
    $_SESSION['info'] = [
      'status' => 'failed',
      'message' => 'Gagal menghapus majalah dari database.'
    ];
    header('Location: ./index.php');
    exit;
  }
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Data majalah tidak ditemukan'
  ];
  header('Location: ./index.php');
  exit;
}