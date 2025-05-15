<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_GET['id'];

// Get image URL before deleting
$query = mysqli_query($connection, "SELECT gambar_url FROM berita WHERE id='$id'");
$berita = mysqli_fetch_assoc($query);

$query = mysqli_query($connection, "SELECT judul FROM berita WHERE id='$id'");
$berita = mysqli_fetch_assoc($query);

// ================================================================================================
// DELETE OPERATIONS
// ================================================================================================

// Delete associated records in berita_tag if they exist
mysqli_query($connection, "DELETE FROM berita_tag WHERE berita_id='$id'");

// Delete the berita record
$result = mysqli_query($connection, "DELETE FROM berita WHERE id='$id'");

if (mysqli_affected_rows($connection) > 0) {
  // Delete image file if it exists
  if(!empty($berita['gambar_url']) && file_exists('../' . $berita['gambar_url'])) {
    unlink('../' . $berita['gambar_url']);
  }
  
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus berita'
  ];

  logActivity('Menghapus berita', [
    'id' => $id,
    'judul' => $berita['judul']
  ]);

  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
?>
