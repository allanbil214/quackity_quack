<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

// ================================================================================================
// DATA PREPARATION
// ================================================================================================

$id = $_POST['id'];
$judul = $_POST['judul'];
$slug = $_POST['slug'];
$penulis_id = $_POST['penulis_id'];
$kategori_id = $_POST['kategori_id'] ? $_POST['kategori_id'] : "NULL";
$status = $_POST['status'];
$featured = isset($_POST['featured']) ? 1 : 0;
$isi = $_POST['isi'];
$excerpt = $_POST['excerpt'] ? $_POST['excerpt'] : NULL;
$tags = isset($_POST['tags']) ? $_POST['tags'] : [];

// Get current berita data
$current_berita = mysqli_query($connection, "SELECT gambar_url FROM berita WHERE id='$id'");
$berita_data = mysqli_fetch_assoc($current_berita);

// Handle image upload
$gambar_url = $berita_data['gambar_url']; // Keep existing value by default
if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $target_dir = "../uploads/berita/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_extension = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
    $new_filename = time() . '_' . $slug . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if($check !== false) {
        if($berita_data['gambar_url'] && file_exists('../' . $berita_data['gambar_url'])) {
            unlink('../' . $berita_data['gambar_url']);
        }
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar_url = "uploads/berita/" . $new_filename;
        } else {
            $_SESSION['info'] = [
                'status' => 'failed',
                'message' => 'Gagal mengupload gambar'
            ];
            header('Location: ./edit.php?id=' . $id);
            exit;
        }
    } else {
        $_SESSION['info'] = [
            'status' => 'failed',
            'message' => 'File bukan gambar'
        ];
        header('Location: ./edit.php?id=' . $id);
        exit;
    }
}

// Prepare excerpt from isi
if($excerpt === NULL) {
    $excerpt = substr(strip_tags($isi), 0, 300);
    if(strlen(strip_tags($isi)) > 300) {
        $excerpt .= '...';
    }
}

// Escape data for SQL
$judul = mysqli_real_escape_string($connection, $judul);
$isi = mysqli_real_escape_string($connection, $isi);
$excerpt = mysqli_real_escape_string($connection, $excerpt);

// Handle NULL values for SQL
$gambar_url_sql = $gambar_url ? "'$gambar_url'" : "NULL";
$excerpt_sql = $excerpt ? "'$excerpt'" : "NULL";
$kategori_id_sql = $kategori_id !== "NULL" ? "$kategori_id" : "NULL";

// ================================================================================================
// TRANSACTION BEGIN
// ================================================================================================

mysqli_begin_transaction($connection);

try {
    $query = mysqli_query($connection, "UPDATE berita SET 
        judul = '$judul', 
        isi = '$isi', 
        penulis_id = '$penulis_id', 
        kategori_id = $kategori_id_sql, 
        status = '$status', 
        featured = '$featured', 
        gambar_url = $gambar_url_sql, 
        slug = '$slug', 
        excerpt = $excerpt_sql
        WHERE id = '$id'");

    if (!$query) {
        throw new Exception(mysqli_error($connection));
    }

    // Remove existing tag relationships
    $delete_tags = mysqli_query($connection, "DELETE FROM berita_tag WHERE berita_id='$id'");
    if (!$delete_tags) {
        throw new Exception(mysqli_error($connection));
    }

    // Handle tags as comma-separated list
    if(isset($_POST['tags']) && !empty($_POST['tags'])) {
        $tagsList = explode(',', $_POST['tags']);
        foreach($tagsList as $tagName) {
            $tagName = trim($tagName);
            if(empty($tagName)) continue;
            $tagSlug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $tagName));
            $checkTag = mysqli_query($connection, "SELECT id FROM tag WHERE nama='$tagName' OR slug='$tagSlug'");
            if(mysqli_num_rows($checkTag) > 0) {
                $tagData = mysqli_fetch_assoc($checkTag);
                $tag_id = $tagData['id'];
            } else {
                mysqli_query($connection, "INSERT INTO tag (nama, slug) VALUES ('$tagName', '$tagSlug')");
                $tag_id = mysqli_insert_id($connection);
            }
            mysqli_query($connection, "INSERT INTO berita_tag (berita_id, tag_id) VALUES ('$id', '$tag_id')");
        }
    }

    // Commit transaction
    mysqli_commit($connection);

    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah berita'
    ];

    logActivity('Mengubah berita', [
      'id' => $id,
      'judul' => $judul,
      'status' => $status
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