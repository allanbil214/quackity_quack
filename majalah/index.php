<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
    SELECT m.*, u.name as uploader_name
    FROM majalah m
    LEFT JOIN users u ON m.uploaded_by = u.id
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>List Majalah</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Majalah</a>
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
                  <th>Deskripsi</th>
                  <th>File</th>
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
                    <td><?= !empty($data['deskripsi']) ? substr(htmlspecialchars($data['deskripsi']), 0, 100) . '...' : '<em>Tidak ada deskripsi</em>' ?></td>
                    <td>
                      <?php if (isset($data['file_url']) && $data['file_url']): ?>
                        <a href="..<?= htmlspecialchars($data['file_url']) ?>" target="_blank" class="btn btn-sm btn-primary">
                          <i class="fas fa-file fa-fw"></i> Lihat File
                        </a>
                      <?php else: ?>
                        <span class="text-muted"><em>Tidak ada file</em></span>
                      <?php endif; ?>
                    </td>
                    <td><?= date('d-m-Y H:i', strtotime($data['uploaded_at'])) ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus majalah ini?')">
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