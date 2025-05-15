<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
require_once '../helper/auth.php';

isLogin();

// ================================================================================================
// DATA FETCHING
// ================================================================================================

$result = mysqli_query($connection, "
    SELECT al.*, u.name as user_name 
    FROM activity_logs al 
    LEFT JOIN users u ON al.user_id = u.id
    ORDER BY al.waktu DESC
    LIMIT 500
");
?>

<section class="section">
  <div class="section-header">
    <h1>Log Aktivitas</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Pengguna</th>
                  <th>Aksi</th>
                  <th>Waktu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>
                  <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= $data['user_name'] ? htmlspecialchars($data['user_name']) : '<em>Tidak diketahui</em>' ?></td>
                    <td><?= htmlspecialchars($data['aksi']) ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($data['waktu'])) ?></td>
                  </tr>
                <?php
                endwhile;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>

<script src="../assets/js/page/modules-datatables.js"></script>