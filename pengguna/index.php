<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Join with roles table to get role name
$result = mysqli_query($connection, "
    SELECT u.*, r.deskripsi as role_name 
    FROM users u 
    LEFT JOIN roles r ON u.role_id = r.id
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>List Pengguna</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Pengguna</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>Role</th>
                  <th style="width: 150px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>
                  <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= $data['username'] ?></td>
                    <td><?= $data['name'] ?></td>
                    <td><?= $data['role_name'] ? $data['role_name'] : '<em>Tidak ada</em>' ?></td>
                    <td>
                      <?php if ($data['id'] != $_SESSION['login']['id']) : ?>
                        <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure to delete?')">
                          <i class="fas fa-trash fa-fw"></i>
                        </a>
                      <?php else: ?>
                        <button class="btn btn-sm btn-secondary mb-md-0 mb-1" disabled>
                          <i class="fas fa-trash fa-fw"></i>
                        </button>
                      <?php endif; ?>
                      
                      <a class="btn btn-sm btn-info" href="edit.php?id=<?= $data['id'] ?>">
                        <i class="fas fa-edit fa-fw"></i>
                      </a>
                      <a class="btn btn-sm btn-success" href="view.php?id=<?= $data['id'] ?>">
                        <i class="fas fa-eye fa-fw"></i>
                      </a>
                    </td>
                  </tr>
                <?php
                endwhile;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
<!-- Page Specific JS File -->
<?php
if (isset($_SESSION['info'])) :
  if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      iziToast.success({
        title: 'Sukses',
        message: `<?= $_SESSION['info']['message'] ?>`,
        position: 'topCenter',
        timeout: 5000
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      iziToast.error({
        title: 'Gagal',
        message: `<?= $_SESSION['info']['message'] ?>`,
        timeout: 5000,
        position: 'topCenter'
      });
    </script>
<?php
  }

  unset($_SESSION['info']);
  $_SESSION['info'] = null;
endif;
?>
<script src="../assets/js/page/modules-datatables.js"></script>