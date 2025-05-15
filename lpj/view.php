<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id'];

$query = mysqli_query($connection, "
    SELECT l.*, 
           r.deskripsi as divisi_name,
           u1.name as uploader_name,
           u2.name as verifier_name
    FROM lpj l
    LEFT JOIN roles r ON l.divisi_id = r.id
    LEFT JOIN users u1 ON l.uploaded_by = u1.id
    LEFT JOIN users u2 ON l.verified_by = u2.id
    WHERE l.id='$id'
");
$lpj = mysqli_fetch_assoc($query);

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail LPJ</h1>
    <div>
    <a href="./edit.php?id=<?= $id ?>" class="btn btn-info mr-1">Edit</a>
    <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
   </div>
</section>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-3"><?= htmlspecialchars($lpj['judul']) ?></h2>
      
      <?php if($lpj['status'] == 'pending'): ?>
        <div class="alert alert-warning">
          Status: Pending - Menunggu verifikasi
        </div>
      <?php elseif($lpj['status'] == 'verified'): ?>
        <div class="alert alert-success">
          Status: Terverifikasi
        </div>
      <?php else: ?>
        <div class="alert alert-danger">
          Status: Ditolak
        </div>
      <?php endif; ?>

      <hr>

      <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($lpj['id']) ?></dd>

        <dt class="col-sm-3">Judul</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($lpj['judul']) ?></dd>

        <dt class="col-sm-3">Divisi</dt>
        <dd class="col-sm-9"><?= $lpj['divisi_name'] ? htmlspecialchars($lpj['divisi_name']) : '<em>Tidak ada</em>' ?></dd>

        <dt class="col-sm-3">File</dt>
        <dd class="col-sm-9">
          <?php if(!empty($lpj['file_url'])): ?>
            <a href="../<?= $lpj['file_url'] ?>" target="_blank" class="btn btn-sm btn-primary">
              <i class="fas fa-download"></i> Download File
            </a>
          <?php else: ?>
            <em>Tidak ada file</em>
          <?php endif; ?>
        </dd>
        
        <dt class="col-sm-3">Diupload Oleh</dt>
        <dd class="col-sm-9"><?= $lpj['uploader_name'] ? htmlspecialchars($lpj['uploader_name']) : '<em>Unknown</em>' ?></dd>
        
        <dt class="col-sm-3">Tanggal Upload</dt>
        <dd class="col-sm-9"><?= date('d-m-Y H:i', strtotime($lpj['uploaded_at'])) ?></dd>
        
        <?php if($lpj['status'] == 'verified'): ?>
        <dt class="col-sm-3">Diverifikasi Oleh</dt>
        <dd class="col-sm-9"><?= $lpj['verifier_name'] ? htmlspecialchars($lpj['verifier_name']) : '<em>Unknown</em>' ?></dd>
        
        <dt class="col-sm-3">Tanggal Verifikasi</dt>
        <dd class="col-sm-9"><?= $lpj['verified_at'] ? date('d-m-Y H:i', strtotime($lpj['verified_at'])) : '<em>-</em>' ?></dd>
        <?php endif; ?>
      </dl>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>