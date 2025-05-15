<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// ================================================================================================
// PREPARATION
// ================================================================================================

$id = $_GET['id'];

$query = mysqli_query($connection, "
    SELECT k.*, u.name as created_by_name 
    FROM kas k 
    LEFT JOIN users u ON k.dibuat_oleh = u.id
    WHERE k.id='$id'
");
$kas = mysqli_fetch_assoc($query);

if (!$kas) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data kas tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

// Get payments related to this kas
$paymentsQuery = mysqli_query($connection, "
    SELECT kp.*, u.name as user_name, u.username
    FROM kas_pembayaran kp
    LEFT JOIN users u ON kp.user_id = u.id
    WHERE kp.kas_id='$id'
    ORDER BY kp.uploaded_at DESC
");
?>

<!-- // ================================================================================================
// BODY
// ================================================================================================ -->

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail Kas</h1>
    <div>
      <a href="./edit.php?id=<?= $id ?>" class="btn btn-info mr-1">Edit</a>
      <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-3"><?= htmlspecialchars($kas['nama']) ?></h2>

      <hr>

      <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($kas['id']) ?></dd>

        <dt class="col-sm-3">Nama Kas</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($kas['nama']) ?></dd>

        <dt class="col-sm-3">Jumlah</dt>
        <dd class="col-sm-9">Rp <?= number_format($kas['jumlah'], 2, ',', '.') ?></dd>

        <dt class="col-sm-3">Untuk Bulan</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($kas['untuk_bulan']) ?></dd>

        <dt class="col-sm-3">Dibuat Oleh</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($kas['created_by_name']) ?></dd>

        <dt class="col-sm-3">Dibuat Pada</dt>
        <dd class="col-sm-9"><?= date('d/m/Y H:i', strtotime($kas['created_at'])) ?></dd>
      </dl>
    </div>
  </div>
</section>

<section class="section">
  <div class="card">
  <div class="card-header d-flex justify-content-between">
      <h4>Daftar Pembayaran</h4>
      <a href="../kas_pembayaran/create.php" class="btn btn-primary">Tambah Pembayaran</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table-2">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama User</th>
              <th>Username</th>
              <th>File</th>
              <th>Status</th>
              <th>Tanggal Upload</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($paymentsQuery) > 0): ?>
              <?php while ($payment = mysqli_fetch_array($paymentsQuery)): ?>
                <tr>
                  <td><?= $payment['id'] ?></td>
                  <td><?= htmlspecialchars($payment['user_name']) ?></td>
                  <td><?= htmlspecialchars($payment['username']) ?></td>
                  <td>
                    <?php if ($payment['file_url']): ?>
                      <a href="..<?= htmlspecialchars($payment['file_url']) ?>" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-file fa-fw"></i> Lihat File
                      </a>
                    <?php else: ?>
                      <span class="text-muted"><em>Tidak ada file</em></span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php
                      switch($payment['status']) {
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
                  <td><?= date('d/m/Y H:i', strtotime($payment['uploaded_at'])) ?></td>
                  <td>
                      <?php if ($payment['status'] == 'pending'): ?>
                          <form action="../kas_pembayaran/update_status.php" method="POST" class="d-inline">
                              <input type="hidden" name="id" value="<?= $payment['id'] ?>">
                              <input type="hidden" name="status" value="approved">
                              <button type="submit" class="btn btn-sm btn-success">
                                  <i class="fas fa-check fa-fw"></i> Approve
                              </button>
                          </form>
                          <form action="../kas_pembayaran/update_status.php" method="POST" class="d-inline ml-1">
                              <input type="hidden" name="id" value="<?= $payment['id'] ?>">
                              <input type="hidden" name="status" value="rejected">
                              <button type="submit" class="btn btn-sm btn-danger">
                                  <i class="fas fa-times fa-fw"></i> Reject
                              </button>
                          </form>
                      <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada pembayaran untuk kas ini</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>

<script src="../assets/js/page/modules-datatables.js"></script>