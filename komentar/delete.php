<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];

$checkQuery = mysqli_query($connection, "SELECT * FROM komentar WHERE id='$id'");
$output = mysqli_fetch_assoc($checkQuery);

$query = mysqli_query($connection, "DELETE FROM komentar WHERE id='$id'");

if (mysqli_affected_rows($connection) > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus komentar'
  ];

  logActivity('Menghapus komentar', [
    'output' => $output
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