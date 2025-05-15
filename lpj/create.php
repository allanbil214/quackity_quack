<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$divisiQuery = mysqli_query($connection, "SELECT * FROM roles ORDER BY deskripsi ASC");

require_once '../layout/_top.php';
// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Tambah LPJ</h1>
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
                                <td>Divisi</td>
                                <td>
                                    <select class="form-control select2" name="divisi_id" required>
                                        <option value="">- Pilih Divisi -</option>
                                        <?php mysqli_data_seek($divisiQuery, 0); ?>
                                        <?php while($divisi = mysqli_fetch_array($divisiQuery)): ?>
                                            <option value="<?= $divisi['id'] ?>"><?= htmlspecialchars($divisi['deskripsi']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>File LPJ</td>
                                <td><input class="form-control" type="file" name="file_lpj" accept=".pdf" required></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan LPJ">
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