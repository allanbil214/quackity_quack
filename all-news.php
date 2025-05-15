<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pagination setup
$limit = 10; // Number of articles per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count of published articles
$countQuery = mysqli_query($connection, "SELECT COUNT(*) as total FROM berita WHERE status = 'published'");
$totalCount = mysqli_fetch_assoc($countQuery)['total'];
$totalPages = ceil($totalCount / $limit);

// Get all published articles with pagination
$allNewsQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, u.name as penulis_nama, k.nama as kategori_nama
    FROM berita b
    LEFT JOIN users u ON b.penulis_id = u.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.status = 'published'
    ORDER BY b.created_at DESC
    LIMIT $offset, $limit
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

// Get categories for menu and footer
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - Quack Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/allnews.css">
</head>
<body>

    <?php include 'layout/frontend_header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title">Semua Berita</h1>
                    <p class="lead">Temukan berbagai informasi dan berita terbaru yang telah kami publikasikan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- All News Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <?php if (mysqli_num_rows($allNewsQuery) > 0) : ?>
                        <div class="row g-4">
                            <?php while ($article = mysqli_fetch_assoc($allNewsQuery)) : ?>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <?php if (!empty($article['gambar_url'])) : ?>
                                            <img src="<?= htmlspecialchars($article['gambar_url']) ?>" class="card-img-top article-img" alt="<?= htmlspecialchars($article['judul']) ?>">
                                        <?php else : ?>
                                            <div class="card-img-top article-img bg-secondary d-flex align-items-center justify-content-center text-white">
                                                <i class="fas fa-newspaper fa-3x"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <?php if (!empty($article['kategori_nama'])) : ?>
                                                <span class="badge category-badge mb-2"><?= htmlspecialchars($article['kategori_nama']) ?></span>
                                            <?php endif; ?>
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
                                            <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php
                                    // Display page numbers with ellipsis for large page counts
                                    $startPage = max(1, $page - 2);
                                    $endPage = min($totalPages, $page + 2);
                                    
                                    if ($startPage > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                        if ($startPage > 2) {
                                            echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                        }
                                    }
                                    
                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                    }
                                    
                                    if ($endPage < $totalPages) {
                                        if ($endPage < $totalPages - 1) {
                                            echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                        }
                                        echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                    }
                                    ?>
                                    
                                    <?php if ($page < $totalPages) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="alert alert-info">Belum ada berita yang tersedia.</div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
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

    <?php include 'layout/frontend_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>