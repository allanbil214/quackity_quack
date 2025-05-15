<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

// ================================================================================================
// PREPARATION
// ================================================================================================

isLogin();

$id = $_GET['id'];

$query = mysqli_query($connection, "SELECT * FROM kategori WHERE id='$id'");
$kategori = mysqli_fetch_assoc($query);

if (!$kategori) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Kategori tidak ditemukan'
    ];
    header('Location: ./index.php');
    exit;
}

// Get related news
$beritaQuery = mysqli_query($connection, "
    SELECT b.*, u.name as penulis_nama 
    FROM berita b 
    LEFT JOIN users u ON b.penulis_id = u.id
    WHERE b.kategori_id='$id'
    ORDER BY b.created_at DESC
    LIMIT 10
");

// Get total count of news with this category
$countQuery = mysqli_query($connection, "SELECT COUNT(id) as total FROM berita WHERE kategori_id='$id'");
$totalBerita = mysqli_fetch_assoc($countQuery)['total'];

// ================================================================================================
// BODY
// ================================================================================================

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Detail Kategori</h1>
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
                            <td width="20%">ID</td>
                            <td><?= $kategori['id'] ?></td>
                        </tr>
                        <tr>
                            <td>Nama Kategori</td>
                            <td><h4><?= htmlspecialchars($kategori['nama']) ?></h4></td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td><code><?= htmlspecialchars($kategori['slug']) ?></code></td>
                        </tr>
                        <tr>
                            <td>Tanggal Dibuat</td>
                            <td><?= date('d/m/Y H:i', strtotime($kategori['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Berita</td>
                            <td><strong><?= $totalBerita ?></strong> berita</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if (mysqli_num_rows($beritaQuery) > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Berita Terbaru dalam Kategori Ini</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($berita = mysqli_fetch_assoc($beritaQuery)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($berita['judul']) ?></td>
                                    <td><?= htmlspecialchars($berita['penulis_nama']) ?></td>
                                    <td>
                                        <?php if($berita['status'] == 'published'): ?>
                                            <span class="badge badge-success">Published</span>
                                        <?php elseif($berita['status'] == 'draft'): ?>
                                            <span class="badge badge-warning">Draft</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Archived</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small><?= date('d/m/Y', strtotime($berita['created_at'])) ?></small></td>
                                    <td>
                                        <a href="../berita/view.php?id=<?= $berita['id'] ?>" class="btn btn-sm btn-success">
                                            <i class="fas fa-eye fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($totalBerita > 10): ?>
                    <div class="text-center mt-3">
                        <em>Menampilkan 10 dari <?= $totalBerita ?> berita</em>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>

<?php 
// ================================================================================================
// PAGE LAYOUT - BOTTOM
// ================================================================================================

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