<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
    SELECT l.*, r.deskripsi as divisi_name, u1.name as uploader_name, u2.name as verifier_name
    FROM lpj l
    LEFT JOIN roles r ON l.divisi_id = r.id
    LEFT JOIN users u1 ON l.uploaded_by = u1.id
    LEFT JOIN users u2 ON l.verified_by = u2.id
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>List LPJ</h1>
    <a href="./create.php" class="btn btn-primary">Tambah LPJ</a>
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
                  <th>Judul</th>
                  <th>Divisi</th>
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
                    <td><?= $data['judul'] ?></td>
                    <td><?= $data['divisi_name'] ? $data['divisi_name'] : '<em>Tidak ada</em>' ?></td>
                    <td>
                      <?php if (isset($data['file_url']) && $data['file_url']): ?>
                        <a href="..<?= htmlspecialchars($data['file_url']) ?>" target="_blank" class="btn btn-sm btn-primary">
                          <i class="fas fa-file fa-fw"></i> Lihat File
                        </a>
                      <?php else: ?>
                        <span class="text-muted"><em>Tidak ada file</em></span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        <?php if($data['status'] == 'pending'): ?>
                          <span class="badge badge-warning">Pending</span>
                          <a class="pl-2 pr-2">|</a>
                          <div class="">
                            <a class="btn btn-sm btn-success" href="change_status.php?id=<?= $data['id'] ?>&status=verified" onclick="return confirm('Verifikasi LPJ ini?')">
                              <i class="fas fa-check fa-fw"></i> Verify
                            </a>
                            <a class="pl-1 pr-1">or</div>
                            <a class="btn btn-sm btn-danger" href="change_status.php?id=<?= $data['id'] ?>&status=rejected" onclick="return confirm('Tolak LPJ ini?')">
                              <i class="fas fa-times fa-fw"></i> Reject
                            </a>
                          </div>
                        <?php elseif($data['status'] == 'verified'): ?>
                          <span class="badge badge-success">Verified</span>

                        <?php else: ?>
                          <span class="badge badge-danger">Rejected</span>
                        <?php endif; ?>
                      </div>
                    </td>

                    <td><?= date('d-m-Y H:i', strtotime($data['uploaded_at'])) ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus LPJ ini?')">
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