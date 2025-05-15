<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM kas_pembayaran WHERE id='$id'");
$pembayaran = mysqli_fetch_assoc($query);

if (!$pembayaran) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data pembayaran kas tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

// Only allow editing if the payment is still pending
if ($pembayaran['status'] !== 'pending') {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Pembayaran yang sudah diproses tidak dapat diubah.'];
    header('Location: ./index.php');
    exit;
}

// Get all available kas options for the dropdown
$kasQuery = mysqli_query($connection, "SELECT * FROM kas ORDER BY created_at DESC");

require_once '../layout/_top.php';

// ================================================================================================
// BODY
// ================================================================================================

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Ubah Pembayaran Kas</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $pembayaran['id'] ?>">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">ID Pembayaran</td>
                                <td><input class="form-control" type="number" name="id" size="20" value="<?= htmlspecialchars($pembayaran['id']) ?>" readonly></td>
                            </tr>

                            <tr>
                                <td>Kas</td>
                                <td>
                                    <select class="form-control" name="kas_id" required>
                                        <option value="">- Pilih Kas -</option>
                                        <?php while ($kas = mysqli_fetch_array($kasQuery)): ?>
                                            <option value="<?= $kas['id'] ?>" <?= ($pembayaran['kas_id'] == $kas['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($kas['nama']) ?> - 
                                                <?= htmlspecialchars($kas['untuk_bulan']) ?> - 
                                                Rp <?= number_format($kas['jumlah'], 2, ',', '.') ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Bukti Pembayaran Saat Ini</td>
                                <td>
                                    <?php if ($pembayaran['file_url']): ?>
                                        <a href="<?= htmlspecialchars($pembayaran['file_url']) ?>" target="_blank" class="btn btn-sm btn-primary mb-2">
                                            <i class="fas fa-file fa-fw"></i> Lihat File
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><em>Tidak ada file</em></span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Ubah Bukti Pembayaran</td>
                                <td>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file">
                                        <label class="custom-file-label" for="file">Pilih file baru (opsional)</label>
                                    </div>
                                    <small class="form-text text-muted">Upload bukti pembayaran (jpg, jpeg, png, pdf). Maks. 2MB</small>
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
require_once '../layout/_bottom.php';
?>

<?php
// ================================================================================================
// SCRIPT FOR THIS PAGE
// ================================================================================================

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

<script>
// Show filename in custom file input
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>