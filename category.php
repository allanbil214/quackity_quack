<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the category slug from URL
$category_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// If no slug provided, redirect to home
if (empty($category_slug)) {
    header('Location: home.php');
    exit;
}

// Get category info
$categoryQuery = mysqli_query($connection, "
    SELECT * FROM kategori WHERE slug = '$category_slug'
");

// Check if category exists
if (mysqli_num_rows($categoryQuery) == 0) {
    header('Location: home.php');
    exit;
}

$category = mysqli_fetch_assoc($categoryQuery);
$category_id = $category['id'];

// Get articles from this category with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

$articlesQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, u.name as penulis_nama
    FROM berita b
    LEFT JOIN users u ON b.penulis_id = u.id
    WHERE b.kategori_id = $category_id AND b.status = 'published'
    ORDER BY b.created_at DESC
    LIMIT $perPage OFFSET $offset
");

// Get total articles for pagination
$totalQuery = mysqli_query($connection, "
    SELECT COUNT(*) as total FROM berita 
    WHERE kategori_id = $category_id AND status = 'published'
");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalArticles = $totalRow['total'];
$totalPages = ceil($totalArticles / $perPage);

// Get all categories for navigation
$categoriesQuery = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");
$categories = [];
while ($cat = mysqli_fetch_assoc($categoriesQuery)) {
    $categories[] = $cat;
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
    <title><?= htmlspecialchars($category['nama']) ?> - Quack Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/category.css">
</head>
<body>
    
    <?php include 'layout/frontend_header.php'; ?>

    <!-- Category Header -->
    <section class="category-header">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold"><?= htmlspecialchars($category['nama']) ?></h1>
                    <p class="lead"><?= !empty($category['deskripsi']) ? htmlspecialchars($category['deskripsi']) : 'Berita dan informasi terkini dalam kategori ini' ?></p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="meta-info text-white">
                        <i class="fas fa-newspaper me-1"></i> <?= $totalArticles ?> Artikel
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Articles List -->
                <div class="col-lg-8">
                    <?php if (mysqli_num_rows($articlesQuery) > 0) : ?>
                        <div class="row g-4">
                            <?php while ($article = mysqli_fetch_assoc($articlesQuery)) : ?>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <?php if (!empty($article['gambar_url'])) : ?>
                                            <img src="<?= htmlspecialchars($article['gambar_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['judul']) ?>" style="height: 180px; object-fit: cover;">
                                        <?php else : ?>
                                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 180px;">
                                                <i class="fas fa-newspaper fa-3x"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><a href="article.php?slug=<?= htmlspecialchars($article['slug']) ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($article['judul']) ?></a></h5>
                                            <p class="card-text small">
                                                <?= !empty($article['excerpt']) ? htmlspecialchars(substr($article['excerpt'], 0, 100)) . '...' : 'Tidak ada deskripsi' ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <div class="meta-info d-flex justify-content-between">
                                                <span><i class="far fa-user me-1"></i> <?= htmlspecialchars($article['penulis_nama']) ?></span>
                                                <span><i class="far fa-calendar me-1"></i> <?= formatDate($article['created_at']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($totalPages > 1) : ?>
                            <nav aria-label="Page navigation" class="mt-5">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="category.php?slug=<?= $category_slug ?>&page=<?= $page - 1 ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php
                                    $startPage = max(1, $page - 2);
                                    $endPage = min($totalPages, $page + 2);
                                    
                                    if ($startPage > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="category.php?slug=' . $category_slug . '&page=1">1</a></li>';
                                        if ($startPage > 2) {
                                            echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                        }
                                    }
                                    
                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        $activeClass = $i == $page ? 'active' : '';
                                        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="category.php?slug=' . $category_slug . '&page=' . $i . '">' . $i . '</a></li>';
                                    }
                                    
                                    if ($endPage < $totalPages) {
                                        if ($endPage < $totalPages - 1) {
                                            echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                        }
                                        echo '<li class="page-item"><a class="page-link" href="category.php?slug=' . $category_slug . '&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                    }
                                    ?>
                                    
                                    <?php if ($page < $totalPages) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="category.php?slug=<?= $category_slug ?>&page=<?= $page + 1 ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="alert alert-info">Belum ada berita dalam kategori ini.</div>
                    <?php endif; ?>
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
                    </div>
                    
                    <!-- Categories -->
                    <div class="card mb-4">
                        <div class="card-header bg-white border-0">
                            <h4 class="section-title">Kategori Lainnya</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <?php foreach ($categories as $cat) : ?>
                                    <?php if ($cat['slug'] != $category_slug) : ?>
                                        <a href="category.php?slug=<?= htmlspecialchars($cat['slug']) ?>" class="badge bg-light text-dark p-2 m-1">
                                            <?= htmlspecialchars($cat['nama']) ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
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