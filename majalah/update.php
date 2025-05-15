<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'] ? $_POST['deskripsi'] : null;

// Get the current record
$currentQuery = mysqli_query($connection, "SELECT * FROM majalah WHERE id='$id'");
$current = mysqli_fetch_assoc($currentQuery);

if (!$current) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Data majalah tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// Handle file upload if there's a new file
$file_url = $current['file_url'];
if (!empty($_FILES['file_majalah']['name'])) {
    $uploadDir = '../uploads/majalah/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['file_majalah'];
    $fileName = time() . '_' . basename($file['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    $allowTypes = array('pdf');
    if (!in_array($fileType, $allowTypes)) {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Hanya file PDF yang diperbolehkan'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Delete old file if exists
        if (!empty($current['file_url']) && file_exists('../' . $current['file_url'])) {
            unlink('../' . $current['file_url']);
        }
        
        $file_url = '/uploads/majalah/' . $fileName;
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Gagal mengunggah file'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
}

// Prepare SQL with proper handling for NULL values
$deskripsi_sql = $deskripsi !== null ? "'$deskripsi'" : "NULL";

$sql = "UPDATE majalah SET 
    judul = '$judul', 
    deskripsi = $deskripsi_sql,
    file_url = '$file_url'
    WHERE id = '$id'";

$query = mysqli_query($connection, $sql);

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah data majalah'
    ];
    logActivity('Mengubah Majalah', [
        'output' => $current
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