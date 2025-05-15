<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM majalah WHERE id='$id'");
$majalah = mysqli_fetch_assoc($query);

if (!$majalah) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data majalah tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

require_once '../layout/_top.php';

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Ubah Data Majalah</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $majalah['id'] ?>">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">ID Majalah</td>
                                <td><input class="form-control" type="number" name="id" size="20" value="<?= htmlspecialchars($majalah['id']) ?>" readonly></td>
                            </tr>

                            <tr>
                                <td>Judul</td>
                                <td><input class="form-control" type="text" name="judul" size="50" required value="<?= htmlspecialchars($majalah['judul']) ?>"></td>
                            </tr>

                            <tr>
                                <td>Deskripsi</td>
                                <td><textarea class="form-control" name="deskripsi" rows="4"><?= htmlspecialchars($majalah['deskripsi']) ?></textarea></td>
                            </tr>

                            <tr>
                                <td>File Majalah</td>
                                <td>
                                    <?php if (!empty($majalah['file_url'])): ?>
                                        <div class="mb-2">
                                            <p>File saat ini: <a href="../<?= $majalah['file_url'] ?>" target="_blank"><?= basename($majalah['file_url']) ?></a></p>
                                        </div>
                                    <?php endif; ?>
                                    <input class="form-control" type="file" name="file_majalah">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
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