<?php
$role_id = $_SESSION['login']['role_id'];

?>

<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.php">
        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjMs0scM1vjGPRF6e8mMNDsOXSo42RVPQnLXac1aT-ZWI21OuPlE7FJ-J4-rA78ffQcag7d392jhTo_qXwlXHzk04i4jOwlbGQ14Z456grAsO6yWko8FvEJ3z22oyhfdmQnTBlWnHnwulu-/s1600/animalface_duck.png" alt="logo" width="150">
        <p> Quack </p>
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.php">🦆</a>
    </div>
    <ul class="sidebar-menu" style="padding-top: 20px;">
      <li class="menu-header">Dashboard <br> ├&mdash;  <?= $_SESSION['login']['role_desc'] ?></li>
      <li><a class="nav-link" href="../"><i class="fas fa-tachometer-alt"></i> <span>Dasbboard</span></a></li>
      <li><a class="nav-link" href="../home.php"><i class="fas fa-globe"></i> <span>News Site</span></a></li>

      <?php if ($role_id <= 6): ?>
        <li class="menu-header">Main Feature</li>

        <!-- Berita: bisa diakses semua role sampai id 6 -->
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-newspaper"></i> <span>Berita</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../berita/index.php">List</a></li>
            <?php if ($role_id <= 6): // role 1-6 bisa tambah berita ?>
              <li><a class="nav-link" href="../berita/create.php">Tambah Data</a></li>
              <li><a class="nav-link" href="../komentar/index.php">Atur Komentar</a></li>
              <li><a class="nav-link" href="../kategori/index.php">Atur Kategori</a></li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if ($role_id <= 4): // Hanya pemred, redpel, bendahara, sekre ?>
        <!-- Pengguna -->
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Pengguna</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../pengguna/index.php">List</a></li>
            <li><a class="nav-link" href="../pengguna/create.php">Tambah Data</a></li>
          </ul>
        </li>

        <!-- Kas -->
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-wallet"></i> <span>Kas</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../kas/index.php">List</a></li>
            <li><a class="nav-link" href="../kas/create.php">Tambah Data</a></li>
          </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill-wave"></i> <span>Kas Pembayaran</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="../kas_pembayaran/index.php">List</a></li>
                <li><a class="nav-link" href="../kas_pembayaran/create.php">Tambah Data</a></li>
            </ul>
        </li>

        <!-- LPJ -->
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-alt"></i> <span>Laporan LPJ</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../lpj/index.php">List</a></li>
            <li><a class="nav-link" href="../lpj/create.php">Tambah Data</a></li>
          </ul>
        </li>

        <!-- Majalah -->
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book-open"></i> <span>Majalah</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="../majalah/index.php">List</a></li>
            <li><a class="nav-link" href="../majalah/create.php">Tambah Data</a></li>
          </ul>
        </li>

        <!-- Log -->
        <li>
          <a class="nav-link" href="../log/index.php"><i class="fas fa-history"></i> <span>Log Aktivitas</span></a>
        </li>

      <?php endif; ?>
    </ul>
  </aside>
</div>
