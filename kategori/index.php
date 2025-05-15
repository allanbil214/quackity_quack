<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// ================================================================================================
// DATA FETCHING
// ================================================================================================

$result = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");

// Count news for each category
$categoryCounts = [];
$countQuery = mysqli_query($connection, "SELECT kategori_id, COUNT(id) as news_count FROM berita GROUP BY kategori_id");
while ($count = mysqli_fetch_assoc($countQuery)) {
    $categoryCounts[$count['kategori_id']] = $count['news_count'];
}
?>

<!-- // ================================================================================================
// BODY
// ================================================================================================ -->

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>List Kategori</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Kategori</a>
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
                  <th>Nama Kategori</th>
                  <th>Slug</th>
                  <th>Jumlah Berita</th>
                  <th>Tanggal Dibuat</th>
                  <th style="width: 150px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                    $newsCount = isset($categoryCounts[$data['id']]) ? $categoryCounts[$data['id']] : 0;
                ?>
                  <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= htmlspecialchars($data['nama']) ?></td>
                    <td><code><?= htmlspecialchars($data['slug']) ?></code></td>
                    <td><?= $newsCount ?></td>
                    <td>
                      <small><?= date('d/m/Y', strtotime($data['created_at'])) ?></small>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus kategori ini? Semua berita terkait akan kehilangan kategori.')">
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