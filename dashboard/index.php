<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$pengguna = mysqli_query($connection, "SELECT COUNT(*) FROM users");
$berita = mysqli_query($connection, "SELECT COUNT(*) FROM berita");
$kas = mysqli_query($connection, "SELECT COUNT(*) FROM kas");
$lpj = mysqli_query($connection, "SELECT COUNT(*) FROM lpj");

$total_pengguna = mysqli_fetch_array($pengguna)[0];
$total_berita = mysqli_fetch_array($berita)[0];
$total_kas = mysqli_fetch_array($kas)[0];
$total_lpj = mysqli_fetch_array($lpj)[0];
?>

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="column">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-newspaper"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Berita</h4>
            </div>
            <div class="card-body">
              <?= $total_berita ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Pengguna</h4>
            </div>
            <div class="card-body">
              <?= $total_pengguna ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-wallet"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Kas</h4>
            </div>
            <div class="card-body">
              <?= $total_kas ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="far fa-file-alt"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Laporan LPJ</h4>
            </div>
            <div class="card-body">
              <?= $total_lpj ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>