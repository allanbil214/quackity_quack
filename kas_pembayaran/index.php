<?php
// ================================================================================================
// DATA FETCHING
// ================================================================================================

require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Get all payment records with user and kas information
$result = mysqli_query($connection, "
    SELECT kp.*, k.nama as kas_nama, u.name as user_name, u.username
    FROM kas_pembayaran kp
    LEFT JOIN kas k ON kp.kas_id = k.id
    LEFT JOIN users u ON kp.user_id = u.id
    ORDER BY kp.uploaded_at DESC
");
?>
<!-- // ================================================================================================
// BODY
// ================================================================================================ -->

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Pembayaran Kas</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Pembayaran</a>
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
                  <th>Kas</th>
                  <th>User</th>
                  <th>File</th>
                  <th>Status</th>
                  <th>Tanggal Upload</th>
                  <th style="width: 150px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>
                  <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= htmlspecialchars($data['kas_nama']) ?></td>
                    <td><?= htmlspecialchars($data['user_name']) ?> (<?= htmlspecialchars($data['username']) ?>)</td>
                    <td>
                      <?php if ($data['file_url']): ?>
                        <a href="..<?= htmlspecialchars($data['file_url']) ?>" target="_blank" class="btn btn-sm btn-primary">
                          <i class="fas fa-file fa-fw"></i> Lihat File
                        </a>
                      <?php else: ?>
                        <span class="text-muted"><em>Tidak ada file</em></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php
                        switch($data['status']) {
                          case 'pending':
                            echo '<span class="badge badge-warning">Pending</span>';
                            break;
                          case 'approved':
                            echo '<span class="badge badge-success">Approved</span>';
                            break;
                          case 'rejected':
                            echo '<span class="badge badge-danger">Rejected</span>';
                            break;
                        }
                      ?>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($data['uploaded_at'])) ?></td>
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