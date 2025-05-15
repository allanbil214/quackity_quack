<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Data Fetching
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT k.*, b.judul as berita_judul 
          FROM komentar k 
          INNER JOIN berita b ON k.berita_id = b.id";

if ($status_filter !== '') {
  $query .= " WHERE k.status = '$status_filter'";
}

$query .= " ORDER BY k.created_at DESC";
$result = mysqli_query($connection, $query);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Moderasi Komentar</h1>
  </div>
  
  <div class="row mb-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="buttons">
            <a href="index.php" class="btn <?= $status_filter === '' ? 'btn-primary' : 'btn-light' ?>">
              Semua
            </a>
            <a href="index.php?status=pending" class="btn <?= $status_filter === 'pending' ? 'btn-primary' : 'btn-light' ?>">
              Pending
            </a>
            <a href="index.php?status=approved" class="btn <?= $status_filter === 'approved' ? 'btn-primary' : 'btn-light' ?>">
              Approved
            </a>
            <a href="index.php?status=rejected" class="btn <?= $status_filter === 'rejected' ? 'btn-primary' : 'btn-light' ?>">
              Rejected
            </a>
          </div>
        </div>
      </div>
    </div>
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
                  <th>Berita</th>
                  <th>Nama</th>
                  <th>Komentar</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                  <th style="width: 150px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>
                  <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= htmlspecialchars($data['berita_judul']) ?></td>
                    <td><?= htmlspecialchars($data['nama']) ?> <br> <small><?= htmlspecialchars($data['email']) ?></small></td>
                    <td><?= htmlspecialchars(substr($data['isi'], 0, 100)) . (strlen($data['isi']) > 100 ? '...' : '') ?></td>
                    <td>
                      <?php if($data['status'] == 'pending'): ?>
                        <span class="badge badge-warning">Pending</span>
                      <?php elseif($data['status'] == 'approved'): ?>
                        <span class="badge badge-success">Approved</span>
                      <?php else: ?>
                        <span class="badge badge-danger">Rejected</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <small><?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></small>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin ingin menghapus komentar ini?')">
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