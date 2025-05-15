<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; 

// ================================================================================================
// DATA PREPARATION
// ================================================================================================

$nama = $_POST['nama'];
$slug = $_POST['slug'];

// Escape data for SQL
$nama = mysqli_real_escape_string($connection, $nama);
$slug = mysqli_real_escape_string($connection, $slug);

// Check if category with same name or slug already exists
$checkQuery = mysqli_query($connection, "SELECT id FROM kategori WHERE nama='$nama' OR slug='$slug'");
if (mysqli_num_rows($checkQuery) > 0) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Kategori dengan nama atau slug yang sama sudah ada'
    ];
    header('Location: ./create.php');
    exit;
}

// ================================================================================================
// TRANSACTION BEGIN
// ================================================================================================

mysqli_begin_transaction($connection);

try {
    $query = mysqli_query($connection, "INSERT INTO kategori(
        nama, slug
    ) VALUES(
        '$nama', '$slug'
    )");

    if (!$query) {
        throw new Exception(mysqli_error($connection));
    }

    $kategori_id = mysqli_insert_id($connection);

    // Commit transaction
    mysqli_commit($connection);

    // Log the activity
    logActivity('Menambah kategori', [
        'id' => $kategori_id,
        'nama' => $nama
    ]);

    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil menambah kategori'
    ];
    header('Location: ./index.php');
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($connection);

    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => $e->getMessage()
    ];
    header('Location: ./create.php');
}
?>