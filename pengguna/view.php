<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id'];

// Get user details with role info
$query = mysqli_query($connection, "
    SELECT u.*, r.deskripsi as role_name 
    FROM users u 
    LEFT JOIN roles r ON u.role_id = r.id
    WHERE u.id='$id'
");
$user = mysqli_fetch_assoc($query);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail Pengguna</h1>
    <div>
    <a href="./edit.php?id=<?= $id ?>" class="btn btn-info mr-1">Edit</a>
    <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
   </div>
</section>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-3"><?= htmlspecialchars($user['name']) ?></h2>

      <hr>

      <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($user['id']) ?></dd>

        <dt class="col-sm-3">Username</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($user['username']) ?></dd>

        <dt class="col-sm-3">Nama Lengkap</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($user['name']) ?></dd>

        <dt class="col-sm-3">Role</dt>
        <dd class="col-sm-9"><?= $user['role_name'] ? htmlspecialchars($user['role_name']) : '<em>Tidak ada</em>' ?></dd>
        
        <?php if($user['id'] == $_SESSION['login']['id']): ?>
        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9"><span class="badge badge-success">Currently logged in</span></dd>
        <?php endif; ?>
      </dl>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>