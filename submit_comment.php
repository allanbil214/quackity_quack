<?php
require_once './helper/connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $berita_id = isset($_POST['berita_id']) ? mysqli_real_escape_string($connection, $_POST['berita_id']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($connection, $_POST['nama']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($connection, $_POST['email']) : '';
    $website = isset($_POST['website']) ? mysqli_real_escape_string($connection, $_POST['website']) : null;
    $isi = isset($_POST['isi']) ? mysqli_real_escape_string($connection, $_POST['isi']) : '';
    $status = 'pending'; // Default status is pending until approved by admin

    // Validation
    $errors = [];
    
    if (empty($berita_id)) {
        $errors[] = "ID berita tidak valid";
    }
    
    if (empty($nama)) {
        $errors[] = "Nama harus diisi";
    }
    
    if (empty($email)) {
        $errors[] = "Email harus diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($isi)) {
        $errors[] = "Komentar harus diisi";
    }
    
    // If there are no errors, insert the comment into the database
    if (empty($errors)) {
        // Check if the article exists
        $checkArticleQuery = mysqli_query($connection, "SELECT id FROM berita WHERE id='$berita_id' AND status='published'");
        
        if (mysqli_num_rows($checkArticleQuery) === 0) {
            $errors[] = "Artikel tidak ditemukan atau tidak dipublikasikan";
        } else {
            // Insert the comment
            $insertQuery = mysqli_query($connection, "
                INSERT INTO komentar (berita_id, nama, email, isi, status, created_at) 
                VALUES ('$berita_id', '$nama', '$email', '$isi', '$status', NOW())
            ");
            
            if ($insertQuery) {
                // Set a success flag to show message on the article page
                session_start();
                $_SESSION['comment_status'] = [
                    'status' => 'success',
                    'message' => 'Komentar berhasil dikirim dan sedang menunggu moderasi.'
                ];
                
                // Redirect back to the article
                $getSlugQuery = mysqli_query($connection, "SELECT slug FROM berita WHERE id='$berita_id'");
                $slugData = mysqli_fetch_assoc($getSlugQuery);
                header("Location: article.php?slug=" . $slugData['slug'] . "#comments");
                exit;
            } else {
                $errors[] = "Gagal menyimpan komentar: " . mysqli_error($connection);
            }
        }
    }
    
    // If there were errors, store them in session and redirect back
    if (!empty($errors)) {
        session_start();
        $_SESSION['comment_status'] = [
            'status' => 'error',
            'message' => implode(", ", $errors),
            'form_data' => [
                'nama' => $nama,
                'email' => $email,
                'website' => $website,
                'isi' => $isi
            ]
        ];
        
        // Redirect back to the article
        $getSlugQuery = mysqli_query($connection, "SELECT slug FROM berita WHERE id='$berita_id'");
        $slugData = mysqli_fetch_assoc($getSlugQuery);
        header("Location: article.php?slug=" . $slugData['slug'] . "#comments");
        exit;
    }
} else {
    // If accessed directly without POST, redirect to home
    header("Location: home.php");
    exit;
}
?>