<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get search query
$search = isset($_GET['q']) ? $_GET['q'] : '';
$search = mysqli_real_escape_string($connection, $search);

// Initialize variables
$results = [];
$resultsCount = 0;

// Perform search only if query is provided
if (!empty($search)) {
    // Get search results
    $searchQuery = mysqli_query($connection, "
        SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, 
               u.name as penulis_nama, k.nama as kategori_nama 
        FROM berita b
        LEFT JOIN users u ON b.penulis_id = u.id
        LEFT JOIN kategori k ON b.kategori_id = k.id
        WHERE b.status = 'published' 
        AND (
            b.judul LIKE '%$search%' 
            OR b.isi LIKE '%$search%' 
            OR b.excerpt LIKE '%$search%'
            OR u.name LIKE '%$search%'
            OR k.nama LIKE '%$search%'
        )
        ORDER BY b.created_at DESC
    ");

    $resultsCount = mysqli_num_rows($searchQuery);
}

// Get categories for navbar and footer
$categoriesQuery = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");
$categories = [];
while ($category = mysqli_fetch_assoc($categoriesQuery)) {
    $categories[] = $category;
}

// Get popular articles for sidebar
$popularQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.view_count, b.created_at, 
           u.name as penulis_nama, k.nama as kategori_nama
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
    <title>Hasil Pencarian "<?= htmlspecialchars($search) ?>" - Quack Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/search.css">
</head>
<body>
    
    <?php include 'layout/frontend_header.php'; ?>

    <!-- Search Header -->
    <section class="search-header">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <?php if (!empty($search)) : ?>
                        <h1>Hasil Pencarian: "<?= htmlspecialchars($search) ?>"</h1>
                        <p class="lead">Ditemukan <?= $resultsCount ?> hasil pencarian.</p>
                    <?php else : ?>
                        <h1>Pencarian</h1>
                        <p class="lead">Silakan masukkan kata kunci pencarian.</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-md-end">
                    <img src="assets/img/search-illustration.svg" alt="Ilustrasi Pencarian" class="img-fluid" style="max-height: 120px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Search Results -->
                <div class="col-lg-8">
                    <?php if (!empty($search)) : ?>
                        <?php if ($resultsCount > 0) : ?>
                            <div class="row g-4">
                                <?php while ($result = mysqli_fetch_assoc($searchQuery)) : ?>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <?php if (!empty($result['gambar_url'])) : ?>
                                                <img src="<?= htmlspecialchars($result['gambar_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($result['judul']) ?>" style="height: 180px; object-fit: cover;">
                                            <?php else : ?>
                                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 180px;">
                                                    <i class="fas fa-newspaper fa-3x"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <?php if (!empty($result['kategori_nama'])) : ?>
                                                    <span class="badge category-badge mb-2"><?= htmlspecialchars($result['kategori_nama']) ?></span>
                                                <?php endif; ?>
                                                <h5 class="card-title">
                                                    <a href="article.php?slug=<?= htmlspecialchars($result['slug']) ?>" class="text-decoration-none text-dark">
                                                        <?php 
                                                        // Highlight search term in title
                                                        $highlighted_title = preg_replace('/(' . preg_quote($search, '/') . ')/i', '<span class="highlight">$1</span>', htmlspecialchars($result['judul']));
                                                        echo $highlighted_title;
                                                        ?>
                                                    </a>
                                                </h5>
                                                <p class="card-text small">
                                                    <?php 
                                                    if (!empty($result['excerpt'])) {
                                                        // Highlight search term in excerpt
                                                        $excerpt = htmlspecialchars(substr($result['excerpt'], 0, 120)) . '...';
                                                        $highlighted_excerpt = preg_replace('/(' . preg_quote($search, '/') . ')/i', '<span class="highlight">$1</span>', $excerpt);
                                                        echo $highlighted_excerpt;
                                                    } else {
                                                        echo 'Tidak ada deskripsi';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="card-footer bg-white border-0">
                                                <div class="meta-info d-flex justify-content-between">
                                                    <span><i class="far fa-user me-1"></i> <?= htmlspecialchars($result['penulis_nama']) ?></span>
                                                    <span><i class="far fa-calendar me-1"></i> <?= formatDate($result['created_at']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Tidak ditemukan hasil untuk pencarian "<?= htmlspecialchars($search) ?>". Silakan coba dengan kata kunci lain.
                            </div>
                            <div class="text-center mt-4">
                                <a href="home.php" class="btn btn-primary">Kembali ke Beranda</a>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-4x mb-3 text-secondary"></i>
                            <h3>Silakan Masukkan Kata Kunci Pencarian</h3>
                            <p class="text-muted">Gunakan form pencarian di atas untuk menemukan artikel yang Anda cari.</p>
                        </div>
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
                    
                    <!-- Search Tips -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="section-title">Tips Pencarian</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Gunakan kata kunci yang spesifik</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Coba berbagai kata kunci terkait</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Periksa ejaan kata kunci Anda</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Gunakan kata dasar untuk hasil lebih luas</li>
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