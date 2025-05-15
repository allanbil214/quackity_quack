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
        <h1>Detail Komentar</h1>
        <div>
            <a href="./edit.php?id=<?= $id ?>" class="btn btn-info mr-1">Edit</a>
            <a href="./index.php" class="btn btn-light">Kembali</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table cellpadding="8" class="w-100">
                        <tr>
                            <td width="15%">ID</td>
                            <td><?= $komentar['id'] ?></td>
                        </tr>

                        <tr>
                            <td>Berita</td>
                            <td>
                                <a href="../view.php?id=<?= $komentar['berita_id'] ?>" target="_blank">
                                    <?= htmlspecialchars($komentar['berita_judul']) ?>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Nama</td>
                            <td><?= htmlspecialchars($komentar['nama']) ?></td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td><?= htmlspecialchars($komentar['email']) ?></td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td>
                                <?php if ($komentar['status'] == 'pending') : ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php elseif ($komentar['status'] == 'approved') : ?>
                                    <span class="badge badge-success">Approved</span>
                                <?php else : ?>
                                    <span class="badge badge-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Tanggal</td>
                            <td><?= date('d/m/Y H:i', strtotime($komentar['created_at'])) ?></td>
                        </tr>

                        <tr>
                            <td>Isi Komentar</td>
                            <td>
                                <div class="p-3 bg-light rounded">
                                    <?= nl2br(htmlspecialchars($komentar['isi'])) ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <?php if ($komentar['status'] == 'pending') : ?>
                                <form action="update_status.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $komentar['id'] ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form action="update_status.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $komentar['id'] ?>">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                                <?php elseif ($komentar['status'] == 'approved') : ?>
                                <form action="update_status.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $komentar['id'] ?>">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                                <?php elseif ($komentar['status'] == 'rejected') : ?>
                                <form action="update_status.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $komentar['id'] ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
require_once '../layout/_bottom.php'; 
?>

<?php if (isset($_SESSION['info'])) : ?>
<script>
    if (typeof iziToast !== 'undefined') {
        iziToast.<?= $_SESSION['info']['status'] === 'success' ? 'success' : 'error' ?>({
            title: "<?= $_SESSION['info']['status'] === 'success' ? 'Sukses' : 'Gagal' ?>",
            message: "<?= $_SESSION['info']['message'] ?>",
            position: "topCenter",
            timeout: 5000
        });
    } else {
        alert('<?= $_SESSION['info']['status'] === 'success' ? 'Success' : 'Error' ?>: <?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>');
    }
</script>
<?php unset($_SESSION['info']); ?>
<?php endif; ?>