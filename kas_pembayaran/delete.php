<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];

// Check if payment exists
$checkQuery = mysqli_query($connection, "SELECT * FROM kas_pembayaran WHERE id='$id'");
$payment = mysqli_fetch_assoc($checkQuery);

$query = mysqli_query($connection, "SELECT kas_id FROM kas_pembayaran WHERE id='$id'");
$kasid = mysqli_fetch_assoc($query);

$query = mysqli_query($connection, "SELECT user_id FROM kas_pembayaran WHERE id='$id'");
$userid = mysqli_fetch_assoc($query);

$query = mysqli_query($connection, "SELECT file_url FROM kas_pembayaran WHERE id='$id'");
$fileurl = mysqli_fetch_assoc($query);

$query = mysqli_query($connection, "SELECT status FROM kas_pembayaran WHERE id='$id'");
$status = mysqli_fetch_assoc($query);


if (!$payment) {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Data pembayaran tidak ditemukan'
  ];
  header('Location: ./index.php');
  exit;
}

// Check if user is allowed or the owner of the payment
$isAdmin = in_array($_SESSION['login']['role_id'], [1, 2, 3, 4]);
$isOwner = $_SESSION['login']['id'] === $payment['user_id'];

if (!$isAdmin && !$isOwner) {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Anda tidak memiliki hak untuk menghapus pembayaran ini'
  ];
  header('Location: ./index.php');
  exit;
}

// Cannot delete if already approved
if ($payment['status'] === 'approved' && !$isAdmin) {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => 'Pembayaran yang sudah disetujui tidak dapat dihapus'
  ];
  header('Location: ./index.php');
  exit;
}

// Delete file if exists
if ($payment['file_url'] && file_exists('..' . $payment['file_url'])) {
  unlink('..' . $payment['file_url']);
}

// Delete the payment record
$result = mysqli_query($connection, "DELETE FROM kas_pembayaran WHERE id='$id'");

if (mysqli_affected_rows($connection) > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus data pembayaran kas'
  ];

  logActivity('Menghapus kas_pembayaran', [
    'id' => $id,
    'kas_id' => $kasid,
    'user_id' => $userid,
    'file_url' => $fileurl,
    'status' => $status
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