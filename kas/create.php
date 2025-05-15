<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

require_once '../layout/_top.php';
?>

<!-- ================================================================================================ -->
<!-- PAGE CONTENT -->
<!-- ================================================================================================ -->

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Tambah Kas</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./store.php" method="POST">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">Nama Kas</td>
                                <td><input class="form-control" type="text" name="nama" size="20" required></td>
                            </tr>

                            <tr>
                                <td>Jumlah</td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input class="form-control" type="number" name="jumlah" step="0.01" min="0" required>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Untuk Bulan</td>
                                <td>
                                    <select class="form-control" name="untuk_bulan" required>
                                        <option value="">- Pilih Bulan -</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan Kas">
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

<!-- ================================================================================================ -->
<!-- PAGE LAYOUT - BOTTOM -->
<!-- ================================================================================================ -->

<?php require_once '../layout/_bottom.php'; ?>

<?php if (isset($_SESSION['info'])) : ?>
    <script>
        <?php if ($_SESSION['info']['status'] == 'success') : ?>
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
        <?php else : ?>
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
        <?php endif; ?>
    </script>
    <?php unset($_SESSION['info']); ?>
<?php endif; ?>
