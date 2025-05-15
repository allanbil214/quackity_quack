<?php
session_start();
require_once '../helper/connection.php';
require_once '../helper/logger.php'; 

$nama = $_POST['nama'];
$jumlah = $_POST['jumlah'];
$untuk_bulan = $_POST['untuk_bulan'];
$dibuat_oleh = $_SESSION['login']['id'];

$query = mysqli_query($connection, "INSERT INTO kas(
    nama, jumlah, untuk_bulan, dibuat_oleh
) VALUES(
    '$nama', '$jumlah', '$untuk_bulan', '$dibuat_oleh'
)");

if ($query) {
    $_SESSION['info'] = [
        'status' => 'success',
        'message' => 'Berhasil menambah data kas'
    ];

    logActivity('Menambah kas', [
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
    header('Location: ./create.php');
}
?>