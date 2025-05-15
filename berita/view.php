<?php
require_once '../helper/auth.php';
require_once '../helper/connection.php';

// ================================================================================================
// PREPARATION
// ================================================================================================

isLogin();

$id = $_GET['id'];

mysqli_query($connection, "UPDATE berita SET view_count = view_count + 1 WHERE id='$id'");

$query = mysqli_query($connection, "
    SELECT b.*, p.name as penulis_nama, k.nama as kategori_nama
    FROM berita b
    LEFT JOIN users p ON b.penulis_id = p.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.id='$id'
");
$berita = mysqli_fetch_assoc($query);

$tagsQuery = mysqli_query($connection, "
    SELECT t.* FROM tag t
    INNER JOIN berita_tag bt ON t.id = bt.tag_id
    WHERE bt.berita_id='$id'
");

// ================================================================================================
// BODY
// ================================================================================================

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Detail Berita</h1>
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
                            <td colspan="2">
                                <h2 class="mb-3"><?= htmlspecialchars($berita['judul']) ?></h2>
                                <?php if (!empty($berita['gambar_url'])) : ?>
                                    <div class="mb-3" style="text-align: center">
                                        <img src="../<?= htmlspecialchars($berita['gambar_url']) ?>" alt="Gambar Berita" class="img-fluid rounded" style="max-height: 400px;">
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <?php if (!empty($berita['excerpt'])) : ?>
                                    <div class="p-3 bg-light rounded mb-3">
                                        <?= htmlspecialchars($berita['excerpt']) ?>
                                    </div>
                                <?php else : ?>
                                    <em>Tidak ada excerpt</em>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="content-wrapper mb-4">
                                    <?= $berita['isi'] ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><hr></td>
                        </tr>

                        <tr class="py-1">
                            <td width="15%">Penulis</td>
                            <td><?= htmlspecialchars($berita['penulis_nama']) ?></td>
                        </tr>

                        <tr class="py-1">
                            <td>Kategori</td>
                            <td><?= $berita['kategori_nama'] ? htmlspecialchars($berita['kategori_nama']) : '<em>Tidak ada</em>' ?></td>
                        </tr>

                        <tr class="py-1">
                            <td>Status</td>
                            <td>
                                <?php if ($berita['status'] == 'published') : ?>
                                    <span class="badge badge-success">Published</span>
                                <?php elseif ($berita['status'] == 'draft') : ?>
                                    <span class="badge badge-warning">Draft</span>
                                <?php else : ?>
                                    <span class="badge badge-secondary">Archived</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr class="py-1">
                            <td>Featured</td>
                            <td>
                                <?php if ($berita['featured']) : ?>
                                    <span class="badge badge-primary"><i class="fas fa-star"></i> Ya</span>
                                <?php else : ?>
                                    <span class="badge badge-light">Tidak</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr class="py-1">
                            <td>Tags</td>
                            <td>
                                <?php
                                if (mysqli_num_rows($tagsQuery) > 0) {
                                    while ($tag = mysqli_fetch_assoc($tagsQuery)) {
                                        echo '<span class="badge badge-info mr-1">' . htmlspecialchars($tag['nama']) . '</span>';
                                    }
                                } else {
                                    echo '<em>Tidak ada tag</em>';
                                }
                                ?>
                            </td>
                        </tr>

                        <tr class="py-1">
                            <td>Slug</td>
                            <td><code><?= htmlspecialchars($berita['slug']) ?></code></td>
                        </tr>

                        <tr class="py-1">
                            <td>Tanggal Dibuat</td>
                            <td><?= date('d/m/Y H:i', strtotime($berita['created_at'])) ?></td>
                        </tr>

                        <tr class="py-1">
                            <td>Terakhir Diupdate</td>
                            <td>
                                <?php if ($berita['updated_at']) : ?>
                                    <?= date('d/m/Y H:i', strtotime($berita['updated_at'])) ?>
                                <?php else : ?>
                                    <em>Belum pernah diupdate</em>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr class="py-1">
                            <td>View Count</td>
                            <td><b><?= $berita['view_count'] ?></b> kali dilihat</td>
                        </tr>
                    </table>
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
