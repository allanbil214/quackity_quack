<?php
// ================================================================================================
// PREPARATION
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "
    SELECT kp.*, k.nama as kas_nama, k.jumlah as kas_jumlah, k.untuk_bulan, 
           u.name as full_name, u.username
    FROM kas_pembayaran kp
    LEFT JOIN kas k ON kp.kas_id = k.id
    LEFT JOIN users u ON kp.user_id = u.id
    WHERE kp.id='$id'
");
$pembayaran = mysqli_fetch_assoc($query);

if (!$pembayaran) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data pembayaran kas tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

// Check if user is admin
$isAdmin = in_array($_SESSION['login']['role_id'], [1, 2, 3, 4]);

require_once '../layout/_top.php';

// ================================================================================================
// BODY
// ================================================================================================

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Detail Pembayaran Kas</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Pembayaran #<?= $pembayaran['id'] ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ID Pembayaran</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= $pembayaran['id'] ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Kas</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= htmlspecialchars($pembayaran['kas_nama']) ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Untuk Bulan</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= htmlspecialchars($pembayaran['untuk_bulan']) ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Jumlah</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static">Rp <?= number_format($pembayaran['kas_jumlah'], 2, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Pengguna</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= htmlspecialchars($pembayaran['full_name']) ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= htmlspecialchars($pembayaran['username']) ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Tanggal Upload</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= date('d/m/Y H:i', strtotime($pembayaran['uploaded_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <?php
                                    switch($pembayaran['status']) {
                                        case 'pending':
                                            echo '<span class="badge badge-warning">Pending</span>';
                                            break;
                                        case 'approved':
                                            echo '<span class="badge badge-success">Approved</span>';
                                            break;
                                        case 'rejected':
                                            echo '<span class="badge badge-danger">Rejected</span>';
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Bukti Pembayaran</label>
                                <div class="col-sm-8">
                                    <?php if ($pembayaran['file_url']): ?>
                                        <a href="..<?= htmlspecialchars($pembayaran['file_url']) ?>" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-file fa-fw"></i> Lihat File
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><em>Tidak ada file</em></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($isAdmin && $pembayaran['status'] === 'pending'): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Verifikasi Pembayaran</h4>
                                </div>
                                <div class="card-body">
                                    <form action="./update_status.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $pembayaran['id'] ?>">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="d-flex">
                                                <button type="submit" name="status" value="approved" class="btn btn-success mr-2">
                                                    <i class="fas fa-check fa-fw"></i> Approve
                                                </button>
                                                <button type="submit" name="status" value="rejected" class="btn btn-danger">
                                                    <i class="fas fa-times fa-fw"></i> Reject
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
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