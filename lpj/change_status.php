<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];
$status = $_GET['status'];
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index';

// Validate status
if (!in_array($status, ['verified', 'rejected'])) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Status tidak valid'
    ];
    header('Location: ./index.php');
    exit;
}

// Get the current record
$query = mysqli_query($connection, "SELECT * FROM lpj WHERE id='$id'");
$lpj = mysqli_fetch_assoc($query);

if (!$lpj) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Data LPJ tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// Update verified information if status changed to verified
$verified_by = "NULL";
$verified_at = "NULL";

if ($status == 'verified') {
    $verified_by = $_SESSION['login']['id'];
    $verified_at = "NOW()";
}

$sql = "UPDATE lpj SET 
    status = '$status',
    verified_by = $verified_by,
    verified_at = $verified_at
    WHERE id = '$id'";

$result = mysqli_query($connection, $sql);

if ($result) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => $status == 'verified' ? 'LPJ berhasil diverifikasi' : 'LPJ berhasil ditolak'
    ];
    logActivity('Update Status LPJ', [
        'output' => $lpj
    ]);
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
}

// Redirect based on the redirect parameter
if ($redirect == 'view') {
    header('Location: ./view.php?id=' . $id);
} else {
    header('Location: ./index.php');
}
?>