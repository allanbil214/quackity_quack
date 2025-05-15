<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// ================================================================================================
// DATA FETCHING
// ================================================================================================

$result = mysqli_query($connection, "
    SELECT k.*, u.name as created_by_name 
    FROM kas k 
    LEFT JOIN users u ON k.dibuat_oleh = u.id
    ORDER BY k.created_at DESC
");
?>

<!-- // ================================================================================================
// BODY
// ================================================================================================ -->

<section class="section">
  
  <div class="section-header d-flex justify-content-between">
    <h1>List Kas</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Kas</a>
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
                  <th>Nama Kas</th>
                  <th>Jumlah</th>
                  <th>Untuk Bulan</th>
                  <th>Dibuat Oleh</th>
                  <th>Tanggal Dibuat</th>
                  <th style="width: 150px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>
                  <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= htmlspecialchars($data['nama']) ?></td>
                    <td>Rp <?= number_format($data['jumlah'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($data['untuk_bulan']) ?></td>
                    <td><?= htmlspecialchars($data['created_by_name']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash fa-fw"></i>
                      </a>
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
// ================================================================================================
// PAGE SPECIFIC JS
// ================================================================================================

require_once '../layout/_bottom.php';
?>

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