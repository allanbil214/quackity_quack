<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM kas WHERE id='$id'");
$kas = mysqli_fetch_assoc($query);

if (!$kas) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data kas tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Ubah Data Kas</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="post">
                        <input type="hidden" name="id" value="<?= $kas['id'] ?>">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">ID Kas</td>
                                <td><input class="form-control" type="number" name="id" size="20" value="<?= htmlspecialchars($kas['id']) ?>" readonly></td>
                            </tr>

                            <tr>
                                <td>Nama Kas</td>
                                <td><input class="form-control" type="text" name="nama" size="20" required value="<?= htmlspecialchars($kas['nama']) ?>"></td>
                            </tr>

                            <tr>
                                <td>Jumlah</td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input class="form-control" type="number" name="jumlah" step="0.01" min="0" required value="<?= $kas['jumlah'] ?>">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Untuk Bulan</td>
                                <td>
                                    <select class="form-control" name="untuk_bulan" required>
                                        <option value="">- Pilih Bulan -</option>
                                        <option value="Januari" <?= $kas['untuk_bulan'] == 'Januari' ? 'selected' : '' ?>>Januari</option>
                                        <option value="Februari" <?= $kas['untuk_bulan'] == 'Februari' ? 'selected' : '' ?>>Februari</option>
                                        <option value="Maret" <?= $kas['untuk_bulan'] == 'Maret' ? 'selected' : '' ?>>Maret</option>
                                        <option value="April" <?= $kas['untuk_bulan'] == 'April' ? 'selected' : '' ?>>April</option>
                                        <option value="Mei" <?= $kas['untuk_bulan'] == 'Mei' ? 'selected' : '' ?>>Mei</option>
                                        <option value="Juni" <?= $kas['untuk_bulan'] == 'Juni' ? 'selected' : '' ?>>Juni</option>
                                        <option value="Juli" <?= $kas['untuk_bulan'] == 'Juli' ? 'selected' : '' ?>>Juli</option>
                                        <option value="Agustus" <?= $kas['untuk_bulan'] == 'Agustus' ? 'selected' : '' ?>>Agustus</option>
                                        <option value="September" <?= $kas['untuk_bulan'] == 'September' ? 'selected' : '' ?>>September</option>
                                        <option value="Oktober" <?= $kas['untuk_bulan'] == 'Oktober' ? 'selected' : '' ?>>Oktober</option>
                                        <option value="November" <?= $kas['untuk_bulan'] == 'November' ? 'selected' : '' ?>>November</option>
                                        <option value="Desember" <?= $kas['untuk_bulan'] == 'Desember' ? 'selected' : '' ?>>Desember</option>
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