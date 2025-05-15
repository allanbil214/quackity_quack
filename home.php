<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get featured articles
$featuredQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, u.name as penulis_nama, k.nama as kategori_nama 
    FROM berita b
    LEFT JOIN users u ON b.penulis_id = u.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.status = 'published' AND b.featured = 1
    ORDER BY b.created_at DESC
    LIMIT 4
");

// Get latest articles
$latestQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, u.name as penulis_nama, k.nama as kategori_nama
    FROM berita b
    LEFT JOIN users u ON b.penulis_id = u.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.status = 'published'
    ORDER BY b.created_at DESC
    LIMIT 6
");

// Get categories
$categoriesQuery = mysqli_query($connection, "
    SELECT kategori.*, COUNT(berita.id) AS total_berita
    FROM kategori
    LEFT JOIN berita ON kategori.id = berita.kategori_id
    GROUP BY kategori.id
    ORDER BY total_berita DESC
    LIMIT 8
");
$categories = [];
while ($category = mysqli_fetch_assoc($categoriesQuery)) {
    $categories[] = $category;
}


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

// Format date function
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d M Y');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quack Berita - Berita Terkini dan Terpercaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
</head>
<body>

    <?php include 'layout/frontend_header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="hero-title">Berita Terkini dan Terpercaya</h1>
                    <p class="lead">Sumber informasi aktual untuk membuat Anda tetap terinformasi dan terupdate.</p>
                </div>
                <div class="col-md-6">
                    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjMs0scM1vjGPRF6e8mMNDsOXSo42RVPQnLXac1aT-ZWI21OuPlE7FJ-J4-rA78ffQcag7d392jhTo_qXwlXHzk04i4jOwlbGQ14Z456grAsO6yWko8FvEJ3z22oyhfdmQnTBlWnHnwulu-/s1600/animalface_duck.png"
                        alt="Ilustrasi Berita"
                        class="img-fluid d-block mx-auto"
                        style="max-width: 300px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Articles -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">Berita Pilihan</h2>
            <div class="row g-4">
                <?php if (mysqli_num_rows($featuredQuery) > 0) : ?>
                    <?php while ($featured = mysqli_fetch_assoc($featuredQuery)) : ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card featured-card h-100">
                                <?php if (!empty($featured['gambar_url'])) : ?>
                                    <img src="<?= htmlspecialchars($featured['gambar_url']) ?>" class="card-img-top featured-img" alt="<?= htmlspecialchars($featured['judul']) ?>">
                                <?php else : ?>
                                    <div class="card-img-top featured-img bg-secondary d-flex align-items-center justify-content-center text-white">
                                        <i class="fas fa-newspaper fa-3x"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <?php if (!empty($featured['kategori_nama'])) : ?>
                                        <span class="badge category-badge mb-2"><?= htmlspecialchars($featured['kategori_nama']) ?></span>
                                    <?php endif; ?>
                                    <h5 class="card-title"><a href="article.php?slug=<?= htmlspecialchars($featured['slug']) ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($featured['judul']) ?></a></h5>
                                    <p class="card-text small">
                                        <?= !empty($featured['excerpt']) ? htmlspecialchars(substr($featured['excerpt'], 0, 100)) . '...' : 'Tidak ada deskripsi' ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="meta-info d-flex justify-content-between">
                                        <span><i class="far fa-user me-1"></i> <?= htmlspecialchars($featured['penulis_nama']) ?></span>
                                        <span><i class="far fa-calendar me-1"></i> <?= formatDate($featured['created_at']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada berita pilihan yang tersedia.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Latest News -->
                <div class="col-lg-8">
                    <h2 class="section-title mb-4">Berita Terbaru</h2>
                    
                    <?php if (mysqli_num_rows($latestQuery) > 0) : ?>
                        <div class="row g-4">
                            <?php while ($latest = mysqli_fetch_assoc($latestQuery)) : ?>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <?php if (!empty($latest['gambar_url'])) : ?>
                                            <img src="<?= htmlspecialchars($latest['gambar_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($latest['judul']) ?>" style="height: 180px; object-fit: cover;">
                                        <?php else : ?>
                                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 180px;">
                                                <i class="fas fa-newspaper fa-3x"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <?php if (!empty($latest['kategori_nama'])) : ?>
                                                <span class="badge category-badge mb-2"><?= htmlspecialchars($latest['kategori_nama']) ?></span>
                                            <?php endif; ?>
                                            <h5 class="card-title"><a href="article.php?slug=<?= htmlspecialchars($latest['slug']) ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($latest['judul']) ?></a></h5>
                                            <p class="card-text small">
                                                <?= !empty($latest['excerpt']) ? htmlspecialchars(substr($latest['excerpt'], 0, 100)) . '...' : 'Tidak ada deskripsi' ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <div class="meta-info d-flex justify-content-between">
                                                <span><i class="far fa-user me-1"></i> <?= htmlspecialchars($latest['penulis_nama']) ?></span>
                                                <span><i class="far fa-calendar me-1"></i> <?= formatDate($latest['created_at']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="all-news.php" class="btn btn-outline-primary">Lihat Semua Berita</a>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info">Belum ada berita yang tersedia.</div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4 mt-5 mt-lg-0">
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
                    </div>
                    
                    <!-- Categories -->
                    <div class="card mb-4">
                        <div class="card-header bg-white border-0">
                            <h4 class="section-title">Kategori</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <?php foreach ($categories as $category) : ?>
                                    <a href="category.php?slug=<?= htmlspecialchars($category['slug']) ?>" class="badge bg-light text-dark p-2 m-1">
                                        <?= htmlspecialchars($category['nama']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">Jelajahi Kategori</h2>

            <div class="d-flex flex-wrap justify-content-center gap-4">
                <?php foreach (array_slice($categories, 0, 8) as $category) : ?>
                    <div class="col-md-3" style="flex: 0 0 23%;">
                        <a href="category.php?slug=<?= htmlspecialchars($category['slug']) ?>" class="text-decoration-none">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="fas fa-folder fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="card-title"><?= htmlspecialchars($category['nama']) ?></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include 'layout/frontend_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>