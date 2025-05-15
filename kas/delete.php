<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; 

$id = $_GET['id'];

// ================================================================================================
// DELETE OPERATIONS
// ================================================================================================

// Check if there are any payments linked to this kas
$checkPayments = mysqli_query($connection, "SELECT COUNT(*) as count FROM kas_pembayaran WHERE kas_id='$id'");
$paymentCount = mysqli_fetch_assoc($checkPayments);

$query_nama = mysqli_query($connection, "SELECT nama FROM kas WHERE id='$id'");
$nama = mysqli_fetch_assoc($query_nama);

$query_jumlah = mysqli_query($connection, "SELECT jumlah FROM kas WHERE id='$id'");
$jumlah = mysqli_fetch_assoc($query_jumlah);

$query_bulan = mysqli_query($connection, "SELECT untuk_bulan FROM kas WHERE id='$id'");
$bulan = mysqli_fetch_assoc($query_jumlah);

if ($paymentCount['count'] > 0) {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Tidak dapat menghapus kas yang memiliki pembayaran terkait'
  ];
  header('Location: ./index.php');
  exit;
}

$result = mysqli_query($connection, "DELETE FROM kas WHERE id='$id'");

if (mysqli_affected_rows($connection) > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus data kas'
  ];

  logActivity('Menghapus kas', [
    'id' => $id,
    'nama' => $nama,
    'jumlah' => $jumlah,
    'untuk_bulan' => $bulan
  ]);

  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
?>