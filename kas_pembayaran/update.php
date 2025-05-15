<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_POST['id'];
$kas_id = $_POST['kas_id'];

// Get current payment data
$current = mysqli_query($connection, "SELECT * FROM kas_pembayaran WHERE id='$id'");
$data = mysqli_fetch_assoc($current);

if (!$data) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Data pembayaran tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// Verify that the payment is still pending
if ($data['status'] !== 'pending') {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Pembayaran yang sudah diproses tidak dapat diubah'
    ];
    header('Location: ./index.php');
    exit;
}

// Check if user is changing to a kas that they've already paid for
if ($kas_id != $data['kas_id']) {
    $user_id = $data['user_id'];
    $checkQuery = mysqli_query($connection, "SELECT COUNT(*) as count FROM kas_pembayaran WHERE kas_id='$kas_id' AND user_id='$user_id' AND id != '$id'");
    $checkResult = mysqli_fetch_assoc($checkQuery);

    if ($checkResult['count'] > 0) {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Anda sudah melakukan pembayaran untuk kas ini'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
}

// Handle file upload
$file_url = $data['file_url'];
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
    $max_size = 2 * 1024 * 1024; // 2MB
    
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Tipe file tidak diizinkan. Gunakan JPG, JPEG, PNG, atau PDF.'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
    
    if ($file_size > $max_size) {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Ukuran file melebihi batas maksimum (2MB)'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
    
    // Create upload directory if not exists
    $upload_dir = '../uploads/pembayaran/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Generate unique filename
    $filename = time() . '_' . $data['user_id'] . '_' . $_FILES['file']['name'];
    $target_file = $upload_dir . $filename;
    
    // Move the uploaded file
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        // Delete old file if exists and is within our uploads directory
        if ($data['file_url'] && file_exists('..' . $data['file_url'])) {
            unlink('..' . $data['file_url']);
        }
        
        $file_url = '/uploads/pembayaran/' . $filename;
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Gagal mengupload file'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
}

$sql = "UPDATE kas_pembayaran SET 
    kas_id = '$kas_id',
    file_url = '$file_url',
    status = 'pending'
    WHERE id = '$id'";

$query = mysqli_query($connection, $sql);

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah data pembayaran kas'
    ];

    logActivity('Mengubah kas_pembayaran', [
        'id' => $id,
        'kas_id' => $kas_id,
        'user_id' => $user_id,
        'file_url' => $file_url,
        'status' => 'pending'
    ]);

    header('Location: ./index.php');
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
    header('Location: ./edit.php?id=' . $id);
}
?>