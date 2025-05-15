<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$kas_id = $_POST['kas_id'];
$user_id = $_SESSION['login']['id'];

// Check if this user has already made a payment for this kas
$checkQuery = mysqli_query($connection, "SELECT COUNT(*) as count FROM kas_pembayaran WHERE kas_id='$kas_id' AND user_id='$user_id'");
$checkResult = mysqli_fetch_assoc($checkQuery);

if ($checkResult['count'] > 0) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Anda sudah melakukan pembayaran untuk kas ini'
    ];
    header('Location: ./create.php');
    exit;
}

// Handle file upload
$file_url = null;
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
        header('Location: ./create.php');
        exit;
    }

    if ($file_size > $max_size) {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Ukuran file melebihi batas maksimum (2MB)'
        ];
        header('Location: ./create.php');
        exit;
    }

    // Create upload directory if not exists
    $upload_dir = '../uploads/pembayaran/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename, replace spaces with underscores
    $original_filename = $_FILES['file']['name'];
    $filename = time() . '_' . $user_id . '_' . str_replace(' ', '_', $original_filename);
    $target_file = $upload_dir . $filename;

    // Move the uploaded file
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $file_url = '/uploads/pembayaran/' . $filename;
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Gagal mengupload file'
        ];
        header('Location: ./create.php');
        exit;
    }
}

$query = mysqli_query($connection, "INSERT INTO kas_pembayaran(
    kas_id, user_id, file_url, status
) VALUES(
    '$kas_id', '$user_id', '$file_url', 'pending'
)");

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengupload pembayaran kas'
    ];

    logActivity('Menambah kas_pembayaran', [
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
    header('Location: ./create.php');
}
?>