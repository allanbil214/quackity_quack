<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];

// Get category info before deleting
$query = mysqli_query($connection, "SELECT nama FROM kategori WHERE id='$id'");
$kategori = mysqli_fetch_assoc($query);

if (!$kategori) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Kategori tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// Check if category is used in berita
$checkBerita = mysqli_query($connection, "SELECT COUNT(id) as count FROM berita WHERE kategori_id='$id'");
$beritaCount = mysqli_fetch_assoc($checkBerita)['count'];

// ================================================================================================
// DELETE OPERATIONS
// ================================================================================================

mysqli_begin_transaction($connection);

try {
    // If berita exists with this category, set kategori_id to NULL
    if ($beritaCount > 0) {
        $updateBerita = mysqli_query($connection, "UPDATE berita SET kategori_id = NULL WHERE kategori_id='$id'");
        if (!$updateBerita) {
            throw new Exception(mysqli_error($connection));
        }
    }

    // Delete the kategori record
    $result = mysqli_query($connection, "DELETE FROM kategori WHERE id='$id'");
    if (!$result) {
        throw new Exception(mysqli_error($connection));
    }

    mysqli_commit($connection);
    
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil menghapus kategori' . ($beritaCount > 0 ? ' dan mengupdate ' . $beritaCount . ' berita terkait' : '')
    ];

    logActivity('Menghapus kategori', [
        'id' => $id,
        'nama' => $kategori['nama'],
        'affected_news' => $beritaCount
    ]);

    header('Location: ./index.php');
} catch (Exception $e) {
    mysqli_rollback($connection);
    
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => $e->getMessage()
    ];
    header('Location: ./index.php');
}
?>