<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; 

$id = $_POST['id'];
$nama = $_POST['nama'];
$jumlah = $_POST['jumlah'];
$untuk_bulan = $_POST['untuk_bulan'];
$dibuat_oleh = $_SESSION['login']['id'];

$sql = "UPDATE kas SET 
    nama = '$nama', 
    jumlah = '$jumlah',
    untuk_bulan = '$untuk_bulan'
    WHERE id = '$id'";

$query = mysqli_query($connection, $sql);

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil mengubah data kas'
    ];

    logActivity('Mengubah kas', [
      'id' => $id,
      'nama' => $nama,
      'jumlah' => $jumlah,
      'untuk_bulan' => $untuk_bulan
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