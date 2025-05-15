<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM kategori WHERE id='$id'");
$kategori = mysqli_fetch_assoc($query);

// Check if category exists
if (!$kategori) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Kategori tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// ================================================================================================
// HTML FORM
// ================================================================================================

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Edit Kategori</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $kategori['id'] ?>">
                        <table cellpadding="8" class="w-100">

                            <tr>
                                <td width="15%">Nama Kategori</td>
                                <td><input class="form-control" type="text" name="nama" id="nama" size="20" value="<?= htmlspecialchars($kategori['nama']) ?>" required></td>
                            </tr>

                            <tr>
                                <td>Slug</td>
                                <td><input class="form-control" type="text" name="slug" id="slug" size="20" value="<?= htmlspecialchars($kategori['slug']) ?>" required></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan Perubahan">
                                    <input class="btn btn-danger" type="reset" name="batal" value="Reset Form">
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// ================================================================================================
// PAGE LAYOUT - BOTTOM
// ================================================================================================
require_once '../layout/_bottom.php';
?>

<script>
  document.getElementById('nama').addEventListener('input', function() {
    const name = this.value;
    let slug = name.toString().toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/\s+/g, '-')
      .replace(/[^\w\-]+/g, '')
      .replace(/\-\-+/g, '-')
      .replace(/^-+/, '')
      .replace(/-+$/, '');
    if (slug === '') { slug = 'n-a'; }
    document.getElementById('slug').value = slug;
  });
</script>

<?php
if (isset($_SESSION['info'])) :
    if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      if (typeof iziToast !== 'undefined') {
          iziToast.success({
              title: 'Sukses!',
              message: `<?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>`,
              position: 'topCenter',
              timeout: 5000
          });
      } else {
          alert('Success: <?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>');
      }
    </script>
<?php
    } else {
?>
    <script>
      if (typeof iziToast !== 'undefined') {
          iziToast.error({
              title: 'Gagal!',
              message: `<?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>`,
              timeout: 5000,
              position: 'topCenter'
          });
      } else {
          alert('Error: <?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>');
      }
    </script>
<?php
    }
    unset($_SESSION['info']);
endif;
?>