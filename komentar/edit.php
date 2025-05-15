<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "
    SELECT k.*, b.judul as berita_judul, b.id as berita_id
    FROM komentar k
    INNER JOIN berita b ON k.berita_id = b.id
    WHERE k.id='$id'
");
$komentar = mysqli_fetch_assoc($query);

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Edit Komentar</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $komentar['id'] ?>">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">Berita</td>
                                <td>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($komentar['berita_judul']) ?>" disabled>
                                    <input type="hidden" name="berita_id" value="<?= $komentar['berita_id'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>Nama</td>
                                <td>
                                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($komentar['nama']) ?>" required>
                                </td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($komentar['email']) ?>" required>
                                </td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    <select class="form-control" name="status" required>
                                        <option value="pending" <?= $komentar['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="approved" <?= $komentar['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="rejected" <?= $komentar['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Isi Komentar</td>
                                <td>
                                    <textarea class="form-control" name="isi" rows="5" required><?= htmlspecialchars($komentar['isi']) ?></textarea>
                                </td>
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
require_once '../layout/_bottom.php';
?>

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