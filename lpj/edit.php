<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM lpj WHERE id='$id'");
$lpj = mysqli_fetch_assoc($query);

if (!$lpj) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data LPJ tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

$divisiQuery = mysqli_query($connection, "SELECT * FROM roles ORDER BY deskripsi ASC");

require_once '../layout/_top.php';

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Ubah Data LPJ</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $lpj['id'] ?>">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">ID LPJ</td>
                                <td><input class="form-control" type="number" name="id" size="20" value="<?= htmlspecialchars($lpj['id']) ?>" readonly></td>
                            </tr>

                            <tr>
                                <td>Judul</td>
                                <td><input class="form-control" type="text" name="judul" size="50" required value="<?= htmlspecialchars($lpj['judul']) ?>"></td>
                            </tr>

                            <tr>
                                <td>Divisi</td>
                                <td>
                                    <select class="form-control select2" name="divisi_id" required>
                                        <option value="">- Pilih Divisi -</option>
                                        <?php mysqli_data_seek($divisiQuery, 0); ?>
                                        <?php while($divisi = mysqli_fetch_array($divisiQuery)): ?>
                                            <option value="<?= $divisi['id'] ?>" <?= ($lpj['divisi_id'] == $divisi['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($divisi['deskripsi']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>File LPJ</td>
                                <td>
                                    <?php if (!empty($lpj['file_url'])): ?>
                                        <div class="mb-2">
                                            <p>File saat ini: <a href="../<?= $lpj['file_url'] ?>" target="_blank"><?= basename($lpj['file_url']) ?></a></p>
                                        </div>
                                    <?php endif; ?>
                                    <input class="form-control" type="file" name="file_lpj">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                                </td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    <select class="form-control" name="status" required>
                                        <option value="pending" <?= ($lpj['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                        <option value="verified" <?= ($lpj['status'] == 'verified') ? 'selected' : '' ?>>Verified</option>
                                        <option value="rejected" <?= ($lpj['status'] == 'rejected') ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan Perubahan">
                                    <a href="./index.php" class="btn btn-danger">Batal</a>
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
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap'
        });
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