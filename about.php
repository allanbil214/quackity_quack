<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get categories for menu
$categoriesQuery = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");
$categories = [];
while ($category = mysqli_fetch_assoc($categoriesQuery)) {
    $categories[] = $category;
}

// Format date function
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d M Y');
}

// Get recent articles for the sidebar
$recentArticlesQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.created_at
    FROM berita b
    WHERE b.status = 'published'
    ORDER BY b.created_at DESC
    LIMIT 3
");

// Get popular articles
$popularQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, u.name as penulis_nama, k.nama as kategori_nama
    FROM berita b
    LEFT JOIN users u ON b.penulis_id = u.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.status = 'published'
    ORDER BY b.view_count DESC
    LIMIT 5
");

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Quack Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/about.css">
</head>
<body>
    
    <?php include 'layout/frontend_header.php'; ?>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">Tentang Kami</h1>
                    <p class="lead">Mengenal lebih dekat tentang Quack Berita, visi dan misi kami dalam menyajikan informasi terpercaya.</p>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title">Siapa Kami</h2>
                    <p class="lead">Quack Berita adalah platform berita digital yang didedikasikan untuk menyediakan informasi aktual, terpercaya, dan berimbang kepada pembaca.</p>
                    
                    <p>Didirikan pada tahun 2020, Quack Berita hadir untuk memenuhi kebutuhan masyarakat akan informasi yang cepat namun tetap menjaga kualitas jurnalistik. Tim kami terdiri dari para jurnalis berpengalaman yang berkomitmen untuk memberikan liputan berita dengan standar etika jurnalistik tertinggi.</p>
                    
                    <p>Kami percaya bahwa informasi yang akurat dan terpercaya adalah hak setiap warga negara. Oleh karena itu, kami selalu berupaya untuk menyajikan berita dengan fakta yang terverifikasi dan menghindari bias dalam pemberitaan. Setiap berita yang kami publikasikan melalui proses verifikasi yang ketat untuk memastikan kualitas dan akurasi informasi.</p>
                    
                    <div class="row g-4 mt-4">
                        <div class="col-md-6">
                            <div class="card mission-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Visi</h5>
                                    <p class="card-text">Menjadi platform berita digital terdepan yang menyajikan informasi terpercaya dan berimbang untuk mencerdaskan masyarakat Indonesia.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mission-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Misi</h5>
                                    <ul class="ps-3">
                                        <li>Menyediakan berita aktual dengan standar jurnalistik tertinggi</li>
                                        <li>Mengedukasi masyarakat melalui konten informatif dan edukatif</li>
                                        <li>Menghadirkan sudut pandang berimbang dalam setiap pemberitaan</li>
                                        <li>Menjunjung tinggi etika jurnalistik dan integritas dalam setiap publikasi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="section-title mt-5">Sejarah Kami</h3>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-year">2020</div>
                            <h5>Pendirian Quack Berita</h5>
                            <p>Quack Berita didirikan oleh sekelompok jurnalis yang memiliki visi untuk menyediakan platform berita digital berkualitas tinggi.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2021</div>
                            <h5>Pengembangan Platform</h5>
                            <p>Quack Berita melakukan pembaruan platform untuk meningkatkan pengalaman pengguna dan memperluas jangkauan distribusi konten.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2022</div>
                            <h5>Perluasan Tim Redaksi</h5>
                            <p>Penambahan jurnalis berpengalaman dan staf teknis untuk meningkatkan kualitas dan kuantitas liputan berita.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2023</div>
                            <h5>Penghargaan Jurnalistik Digital</h5>
                            <p>Quack Berita menerima penghargaan sebagai salah satu platform berita digital terbaik di Indonesia.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2024</div>
                            <h5>Inovasi dan Kolaborasi</h5>
                            <p>Mengembangkan fitur-fitur baru dan menjalin kolaborasi dengan berbagai pihak untuk memperkaya konten dan perspektif.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">   
                    <!-- Popular News -->
                    <div class="card mb-4">
                        <div class="card-header bg-white border-0">
                            <h4 class="section-title">Berita Populer</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush popular-list">
                                <?php 
                                $popularIndex = 1;
                                while ($popular = mysqli_fetch_assoc($popularQuery)) : 
                                ?>
                                    <li class="list-group-item d-flex">
                                        <div class="popular-number me-3"><?= $popularIndex ?></div>
                                        <div>
                                            <a href="article.php?slug=<?= htmlspecialchars($popular['slug']) ?>" class="popular-title text-decoration-none text-dark">
                                                <?= htmlspecialchars($popular['judul']) ?>
                                            </a>
                                            <div class="meta-info">
                                                <i class="far fa-eye me-1"></i> <?= number_format($popular['view_count']) ?> kali dilihat
                                            </div>
                                        </div>
                                    </li>
                                <?php 
                                    $popularIndex++;
                                    endwhile; 
                                ?>
                            </ul>
                        </div>
                    </div>                    <!-- Recent Articles -->
                    <div class="card mb-4">
                        <div class="card-header bg-white border-0">
                            <h4 class="section-title">Artikel Terbaru</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php while ($article = mysqli_fetch_assoc($recentArticlesQuery)) : ?>
                                    <li class="list-group-item px-0">
                                        <a href="article.php?slug=<?= htmlspecialchars($article['slug']) ?>" class="text-decoration-none text-dark">
                                            <div class="d-flex">
                                                <?php if (!empty($article['gambar_url'])) : ?>
                                                    <img src="<?= htmlspecialchars($article['gambar_url']) ?>" class="rounded me-3" alt="<?= htmlspecialchars($article['judul']) ?>" style="width: 80px; height: 60px; object-fit: cover;">
                                                <?php else : ?>
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 60px;">
                                                        <i class="fas fa-newspaper"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1"><?= htmlspecialchars($article['judul']) ?></h6>
                                                    <small class="text-muted"><?= formatDate($article['created_at']) ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'layout/frontend_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>