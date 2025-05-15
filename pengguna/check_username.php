<?php
require_once '../helper/connection.php';

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $check = mysqli_query($connection, "SELECT id FROM users WHERE username = '$username'");
    echo json_encode([
        'exists' => mysqli_num_rows($check) > 0
    ]);
}
?>
