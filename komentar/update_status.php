<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_POST['id'];
$status = $_POST['status'];

$query = mysqli_query($connection, "
    UPDATE komentar SET 
    status = '$status'
    WHERE id = '$id'
");

$checkQuery = mysqli_query($connection, "SELECT * FROM komentar WHERE id='$id'");
$output = mysqli_fetch_assoc($checkQuery);

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Status komentar berhasil diperbarui menjadi ' . ($status == 'approved' ? 'disetujui' : 'ditolak')
    ];
    logActivity('Update Status komentar', [
        'output' => $output
    ]);
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
}

header('Location: ./view.php?id=' . $id);
?>