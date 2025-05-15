<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$judul = $_POST['judul'];
$divisi_id = $_POST['divisi_id'] ? $_POST['divisi_id'] : "NULL";
$uploaded_by = $_SESSION['login']['id'];

$uploadDir = '../uploads/lpj/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$file = $_FILES['file_lpj'];
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
    $file_url = '/uploads/lpj/' . $fileName;
    
    // Handle NULL values correctly for SQL
    $divisi_id_sql = $divisi_id !== "NULL" ? "$divisi_id" : "NULL";

    $query = mysqli_query($connection, "INSERT INTO lpj(
        judul, divisi_id, file_url, status, uploaded_by
    ) VALUES(
        '$judul', $divisi_id_sql, '$file_url', 'pending', '$uploaded_by'
    )");

    if ($query) {
        $_SESSION['info'] = [
            'status' => 'success',
            'message' => 'Berhasil menambah LPJ'
        ];
        header('Location: ./index.php');
        logActivity('Menambah LPJ', [
          'judul' => $judul,
          'divisi_id' => $divisi_id_sql,
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