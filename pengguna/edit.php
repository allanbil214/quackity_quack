<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php';
require_once '../helper/connection.php';

isLogin();

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    $_SESSION['info'] = ['status' => 'error', 'message' => 'Data pengguna tidak ditemukan.'];
    header('Location: ./index.php');
    exit;
}

$rolesQuery = mysqli_query($connection, "SELECT * FROM roles ORDER BY deskripsi ASC");

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

require_once '../layout/_top.php';
?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Ubah Data Pengguna</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./update.php" method="post">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <table cellpadding="8" class="w-100">

                            <tr>
                                <td width="15%">ID Pengguna</td>
                                <td><input class="form-control" type="number" name="id" size="20" value="<?= htmlspecialchars($user['id']) ?>" readonly></td>
                            </tr>

                            <tr>
                                <td>Username</td>
                                <td><input class="form-control" type="text" name="username" size="20" required value="<?= htmlspecialchars($user['username']) ?>"></td>
                            </tr>

                            <tr>
                                <td>Password</td>
                                <td>
                                    <input class="form-control" type="password" name="password" size="20">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                </td>
                            </tr>

                            <tr>
                                <td>Nama Lengkap</td>
                                <td><input class="form-control" type="text" name="name" size="20" required value="<?= htmlspecialchars($user['name']) ?>"></td>
                            </tr>

                            <tr>
                                <td>Role</td>
                                <td>
                                    <select class="form-control select2" name="role_id" required>
                                        <option value="">- Pilih Role -</option>
                                        <?php mysqli_data_seek($rolesQuery, 0); ?>
                                        <?php while($role = mysqli_fetch_array($rolesQuery)): ?>
                                            <option value="<?= $role['id'] ?>" <?= ($user['role_id'] == $role['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($role['deskripsi']) ?>
                                            </option>
                                        <?php endwhile; ?>
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
