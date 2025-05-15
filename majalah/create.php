<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

require_once '../layout/_top.php';
// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Tambah Majalah</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./store.php" method="POST" enctype="multipart/form-data">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">Judul</td>
                                <td><input class="form-control" type="text" name="judul" size="50" required></td>
                            </tr>

                            <tr>
                                <td>Deskripsi</td>
                                <td><textarea class="form-control" name="deskripsi" rows="4"></textarea></td>
                            </tr>

                            <tr>
                                <td>File Majalah</td>
                                <td><input class="form-control" type="file" name="file_majalah" accept=".pdf" required></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan Majalah">
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