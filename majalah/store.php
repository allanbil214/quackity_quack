<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'] ? $_POST['deskripsi'] : null;
$uploaded_by = $_SESSION['login']['id'];

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
    header('Location: ./create.php');
    exit;
}

if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    $file_url = '/uploads/majalah/' . $fileName;
    
    // Prepare SQL with proper handling for NULL values
    $deskripsi_sql = $deskripsi !== null ? "'$deskripsi'" : "NULL";

    $query = mysqli_query($connection, "INSERT INTO majalah(
        judul, deskripsi, file_url, uploaded_by
    ) VALUES(
        '$judul', $deskripsi_sql, '$file_url', '$uploaded_by'
    )");

    if ($query) {
        $_SESSION['info'] = [
            'status' => 'success',
            'message' => 'Berhasil menambah majalah'
        ];
        header('Location: ./index.php');
        logActivity('Menambah Majalah', [
          'judul' => $judul,
          'deskripsi' => $deskripsi,
          'file_url' => $file_url
        ]);
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => mysqli_error($connection)
        ];
        header('Location: ./create.php');
    }
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Gagal mengunggah file'
    ];
    header('Location: ./create.php');
}
?>