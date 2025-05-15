<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];

$query = mysqli_query($connection, "SELECT * FROM lpj WHERE id='$id'");
$lpj = mysqli_fetch_assoc($query);

if ($lpj) {
  // Delete the file if it exists
  if (!empty($lpj['file_url']) && file_exists('../' . $lpj['file_url'])) {
    unlink('../' . $lpj['file_url']);
  }

  // Delete the database record
  $deleteQuery = mysqli_query($connection, "DELETE FROM lpj WHERE id='$id'");
  $affected = mysqli_affected_rows($connection); // simpan jumlah baris yang terpengaruh

  // Lakukan SELECT setelah DELETE (jika masih diperlukan)
  $output = [
    'id' => $lpj['id'],
    'judul' => $lpj['judul'],
    'file_url' => $lpj['file_url']
  ];

  if ($affected > 0) {
    $_SESSION['info'] = [
      'status' => 'success',
      'message' => 'Berhasil menghapus LPJ'
    ];
    logActivity('Menghapus LPJ', [
      'output' => $output
    ]);
    header('Location: ./index.php');
    exit;
  } else {
    $_SESSION['info'] = [
      'status' => 'failed',
      'message' => 'Gagal menghapus LPJ dari database.'
    ];
    header('Location: ./index.php');
    exit;
  }
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Data LPJ tidak ditemukan'
  ];
  header('Location: ./index.php');
  exit;
}
