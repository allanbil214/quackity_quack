<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id'];

$query = mysqli_query($connection, "
    SELECT m.*, 
           u.name as uploader_name
    FROM majalah m
    LEFT JOIN users u ON m.uploaded_by = u.id
    WHERE m.id='$id'
");
$majalah = mysqli_fetch_assoc($query);

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Detail Majalah</h1>
    <div>
    <a href="./edit.php?id=<?= $id ?>" class="btn btn-info mr-1">Edit</a>
    <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
   </div>
</section>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-3"><?= htmlspecialchars($majalah['judul']) ?></h2>
      
      <hr>

      <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($majalah['id']) ?></dd>

        <dt class="col-sm-3">Judul</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($majalah['judul']) ?></dd>

        <dt class="col-sm-3">Deskripsi</dt>
        <dd class="col-sm-9"><?= !empty($majalah['deskripsi']) ? nl2br(htmlspecialchars($majalah['deskripsi'])) : '<em>Tidak ada deskripsi</em>' ?></dd>

        <dt class="col-sm-3">File</dt>
        <dd class="col-sm-9">
          <?php if(!empty($majalah['file_url'])): ?>
            <a href="../<?= $majalah['file_url'] ?>" target="_blank" class="btn btn-sm btn-primary">
              <i class="fas fa-download"></i> Download File
            </a>
          <?php else: ?>
            <em>Tidak ada file</em>
          <?php endif; ?>
        </dd>
        
        <dt class="col-sm-3">Diupload Oleh</dt>
        <dd class="col-sm-9"><?= $majalah['uploader_name'] ? htmlspecialchars($majalah['uploader_name']) : '<em>Unknown</em>' ?></dd>
        
        <dt class="col-sm-3">Tanggal Upload</dt>
        <dd class="col-sm-9"><?= date('d-m-Y H:i', strtotime($majalah['uploaded_at'])) ?></dd>
      </dl>
    </div>
  </div>
</section>

<section class="section">
  <div class="card">
    <div class="card-header">
      <h4>Preview File</h4>
    </div>
    <div class="card-body">
      <?php if(!empty($majalah['file_url'])): ?>
        <div style="height: 500px;">
          <embed src="../<?= $majalah['file_url'] ?>" type="application/pdf" width="100%" height="100%">
        </div>
      <?php else: ?>
        <div class="alert alert-info">Tidak ada file untuk ditampilkan</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>