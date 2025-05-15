<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/auth.php';
require_once '../helper/logger.php';

// Check if the user is allowed
if ($_SESSION['login']['role_id'] < 1 || $_SESSION['login']['role_id'] > 4) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Anda tidak memiliki hak akses untuk melakukan operasi ini'
    ];
    header('Location: ./index.php');
    exit;
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Metode permintaan tidak valid'
    ];
    header('Location: ./index.php');
    exit;
}

$id = $_POST['id'];
$status = $_POST['status'];

// Validate status value
if (!in_array($status, ['approved', 'rejected'])) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Status tidak valid'
    ];
    header('Location: ./view.php?id=' . $id);
    exit;
}

// Check if payment exists and is pending
$checkQuery = mysqli_query($connection, "SELECT * FROM kas_pembayaran WHERE id='$id'");
$output = mysqli_fetch_assoc($checkQuery);

if (!$payment) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Data pembayaran tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

if ($payment['status'] !== 'pending') {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Pembayaran ini sudah diproses sebelumnya'
    ];
    header('Location: ./view.php?id=' . $id);
    exit;
}

// Update payment status
$updateQuery = mysqli_query($connection, "UPDATE kas_pembayaran SET status='$status' WHERE id='$id'");

if ($updateQuery) {
    // Get payment details for message
    $paymentDetailsQuery = mysqli_query($connection, "
        SELECT kp.*, k.nama as kas_nama, k.untuk_bulan, u.name as user_name
        FROM kas_pembayaran kp
        LEFT JOIN kas k ON kp.kas_id = k.id
        LEFT JOIN users u ON kp.user_id = u.id
        WHERE kp.id='$id'
    ");
    $paymentDetails = mysqli_fetch_assoc($paymentDetailsQuery);
    
    $statusText = $status === 'approved' ? 'disetujui' : 'ditolak';
    
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => "Pembayaran kas " . htmlspecialchars($paymentDetails['kas_nama']) . 
                    " untuk bulan " . htmlspecialchars($paymentDetails['untuk_bulan']) . 
                    " oleh " . htmlspecialchars($paymentDetails['user_name']) . 
                    " telah " . $statusText
    ];

    logActivity('Update status kas_pembayaran', [
        'output' => $output
    ]);

    header('Location: ./view.php?id=' . $id);
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
    header('Location: ./view.php?id=' . $id);
}
?>