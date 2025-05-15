<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

// ================================================================================================
// DATA PREPARATION
// ================================================================================================

$id = $_POST['id'];
$nama = $_POST['nama'];
$slug = $_POST['slug'];

// Escape data for SQL
$nama = mysqli_real_escape_string($connection, $nama);
$slug = mysqli_real_escape_string($connection, $slug);

// Check if another category with the same name or slug already exists
$checkQuery = mysqli_query($connection, "SELECT id FROM kategori WHERE (nama='$nama' OR slug='$slug') AND id != '$id'");
if (mysqli_num_rows($checkQuery) > 0) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Kategori dengan nama atau slug yang sama sudah ada'
    ];
    header('Location: ./edit.php?id=' . $id);
    exit;
}

// ================================================================================================
// TRANSACTION BEGIN
// ================================================================================================

mysqli_begin_transaction($connection);

try {
    $query = mysqli_query($connection, "UPDATE kategori SET 
        nama = '$nama', 
        slug = '$slug'
        WHERE id = '$id'");

    if (!$query) {
        throw new Exception(mysqli_error($connection));
    }

    // Commit transaction
    mysqli_commit($connection);

    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah kategori'
    ];

    logActivity('Mengubah kategori', [
      'id' => $id,
      'nama' => $nama
    ]); 

    header('Location: ./index.php');
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($connection);

    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => $e->getMessage()
    ];

    header('Location: ./edit.php?id=' . $id);
}
?>