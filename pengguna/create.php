<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$rolesQuery = mysqli_query($connection, "SELECT * FROM roles ORDER BY deskripsi ASC");

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Tambah Pengguna</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./store.php" method="POST">
                        <table cellpadding="8" class="w-100">

                            <tr>
                                <td width="15%">Username</td>
                                <td><input class="form-control" type="text" name="username" size="20" required></td>
                            </tr>

                            <tr>
                                <td>Password</td>
                                <td><input class="form-control" type="password" name="password" size="20" required></td>
                            </tr>

                            <tr>
                                <td>Nama Lengkap</td>
                                <td><input class="form-control" type="text" name="name" size="20" required></td>
                            </tr>

                            <tr>
                                <td>Role</td>
                                <td>
                                    <select class="form-control select2" name="role_id" required>
                                        <option value="">- Pilih Role -</option>
                                        <?php mysqli_data_seek($rolesQuery, 0); ?>
                                        <?php while($role = mysqli_fetch_array($rolesQuery)): ?>
                                            <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['deskripsi']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan Pengguna">
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
// ================================================================================================
// PAGE LAYOUT - BOTTOM
// ================================================================================================

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
