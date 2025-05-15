<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php';

$id = $_POST['id'];
$nama = mysqli_real_escape_string($connection, $_POST['nama']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$isi = mysqli_real_escape_string($connection, $_POST['isi']);
$status = $_POST['status'];
$berita_id = $_POST['berita_id'];

$query = mysqli_query($connection, "
    UPDATE komentar SET 
    nama = '$nama',
    email = '$email',
    isi = '$isi',
    status = '$status'
    WHERE id = '$id'
");

$checkQuery = mysqli_query($connection, "SELECT * FROM komentar WHERE id='$id'");
$output = mysqli_fetch_assoc($checkQuery);

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengupdate komentar'
    ];

    logActivity('Mengubah komentar', [
        'output' => $output
    ]);

    header('Location: ./view.php?id=' . $id);
} else {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => mysqli_error($connection)
    ];
    header('Location: ./edit.php?id=' . $id);
}
?>