<?php
require_once '../helper/auth.php';
isLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; PLACEHOLDER YA :3</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/modules/izitoast/css/iziToast.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.min.css">

  <!-- Additional Plugins -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="../assets/jquery-ui-1.14.1.custom/jquery-ui.min.css">

  <style>
    .bootstrap-tagsinput {
      width: 100%;
    }

    .bootstrap-tagsinput .tag {
      background-color: #007bff;
      color: white;
      padding: 2px 5px;
      border-radius: 3px;
      margin-right: 2px;
    }

    .ui-autocomplete {
      z-index: 9999 !important;
      max-height: 200px;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .content-wrapper {
        overflow-wrap: break-word;
        word-wrap: break-word;
        line-height: 1.6;
        font-size: 1rem;
    }

    .content-wrapper img {
        max-width: 100%;
        height: auto;
    }

    .content-wrapper table {
        margin-bottom: 1rem;
        background-color: #fff;
    }

    .content-wrapper table, .content-wrapper th, .content-wrapper td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .content-wrapper th {
        background-color: #f8f9fa;
        font-weight: bold;
        text-align: left;
    }
  </style>

</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      
      <?php
      require_once '_header.php';
      require_once '_sidenav.php';
      ?>

      <!-- Main Content -->
      <div class="main-content">
