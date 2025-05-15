<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$divisi_id = $_POST['divisi_id'] ? $_POST['divisi_id'] : "NULL";
$status = $_POST['status'];

// Get the current record to check original status
$currentQuery = mysqli_query($connection, "SELECT * FROM lpj WHERE id='$id'");
$current = mysqli_fetch_assoc($currentQuery);

if (!$current) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Data LPJ tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// Handle file upload if there's a new file
$file_url = $current['file_url'];
if (!empty($_FILES['file_lpj']['name'])) {
    $uploadDir = '../uploads/lpj/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['file_lpj'];
    $fileName = time() . '_' . basename($file['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    $allowTypes = array('pdf', 'doc', 'docx', 'xls', 'xlsx');
    if (!in_array($fileType, $allowTypes)) {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Hanya file PDF, DOC, DOCX, XLS, dan XLSX yang diperbolehkan'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Delete old file if exists
        if (!empty($current['file_url']) && file_exists('../' . $current['file_url'])) {
            unlink('../' . $current['file_url']);
        }
        
        $file_url = '/uploads/lpj/' . $fileName;
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'Gagal mengunggah file'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
}

// Handle NULL values correctly for SQL
$divisi_id_sql = $divisi_id !== "NULL" ? "$divisi_id" : "NULL";

// Update verified information if status changed to verified
$verified_by = "NULL";
$verified_at = "NULL";

if ($status == 'verified' && $current['status'] != 'verified') {
    $verified_by = $_SESSION['login']['id'];
    $verified_at = "NOW()";
} elseif ($current['status'] == 'verified') {
    // Keep existing verification info
    $verified_by = $current['verified_by'] ? $current['verified_by'] : "NULL";
    $verified_at = $current['verified_at'] ? "'" . $current['verified_at'] . "'" : "NULL";
}

$sql = "UPDATE lpj SET 
    judul = '$judul', 
    divisi_id = $divisi_id_sql,
    file_url = '$file_url',
    status = '$status',
    verified_by = $verified_by,
    verified_at = $verified_at
    WHERE id = '$id'";

$query = mysqli_query($connection, $sql);

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah data LPJ'
    ];
    logActivity('Mengubah LPJ', [
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