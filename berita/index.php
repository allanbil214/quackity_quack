<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// ================================================================================================
// DATA FETCHING
// ================================================================================================

$result = mysqli_query($connection, "
    SELECT b.*, p.name as penulis_nama, k.nama as kategori_nama 
    FROM berita b 
    LEFT JOIN users p ON b.penulis_id = p.id 
    LEFT JOIN kategori k ON b.kategori_id = k.id
");
?>

<!-- // ================================================================================================
// BODY
// ================================================================================================ -->

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>List Berita</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Berita</a>
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
                  <th>Penulis</th>
                  <th>Kategori</th>
                  <th>Status</th>
                  <th>Featured</th>
                  <th>View Count</th>
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
                    <td>
                      <?= $data['judul'] ?>
                      <?php if(!empty($data['gambar_url'])): ?>
                        <span class="badge badge-info ml-1"><i class="fas fa-image"></i></span>
                      <?php endif; ?>
                    </td>
                    <td><?= $data['penulis_nama'] ?></td>
                    <td><?= $data['kategori_nama'] ? $data['kategori_nama'] : '<em>Tidak ada</em>' ?></td>
                    <td>
                      <?php if($data['status'] == 'published'): ?>
                        <span class="badge badge-success">Published</span>
                      <?php elseif($data['status'] == 'draft'): ?>
                        <span class="badge badge-warning">Draft</span>
                      <?php else: ?>
                        <span class="badge badge-secondary">Archived</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($data['featured'] == 1): ?>
                        <span class="badge badge-primary"><i class="fas fa-star"></i> Ya</span>
                      <?php else: ?>
                        <span class="badge badge-light">Tidak</span>
                      <?php endif; ?>
                    </td>
                    <td><?= $data['view_count'] ?></td>
                    <td>
                      <small><?= date('d/m/Y', strtotime($data['created_at'])) ?></small>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure to delete?')">
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
// ================================================================================================
// PAGE SPECIFIC JS
// ================================================================================================

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
