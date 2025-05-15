<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header('Location: home.php');
    exit;
}

$slug = mysqli_real_escape_string($connection, $_GET['slug']);

// Get the article details
$query = mysqli_query($connection, "
    SELECT b.*, p.name as penulis_nama, k.nama as kategori_nama, k.slug as kategori_slug
    FROM berita b
    LEFT JOIN users p ON b.penulis_id = p.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    WHERE b.slug='$slug' AND b.status='published'
");

// Check if article exists
if (mysqli_num_rows($query) === 0) {
    header('Location: home.php');
    exit;
}

$article = mysqli_fetch_assoc($query);

// Update view count
mysqli_query($connection, "UPDATE berita SET view_count = view_count + 1 WHERE id='{$article['id']}'");

// Get article tags
$tagsQuery = mysqli_query($connection, "
    SELECT t.* FROM tag t
    INNER JOIN berita_tag bt ON t.id = bt.tag_id
    WHERE bt.berita_id='{$article['id']}'
");

// Get related articles
$relatedQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.excerpt, b.gambar_url, b.slug, b.created_at, u.name as penulis_nama
    FROM berita b
    LEFT JOIN users u ON b.penulis_id = u.id
    WHERE b.status = 'published' 
    AND b.id != '{$article['id']}'
    " . ($article['kategori_id'] ? "AND b.kategori_id = '{$article['kategori_id']}'" : "") . "
    ORDER BY b.created_at DESC
    LIMIT 3
");

// Get categories
$categoriesQuery = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");
$categories = [];
while ($category = mysqli_fetch_assoc($categoriesQuery)) {
    $categories[] = $category;
}

// Get popular articles
$popularQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.slug, b.view_count
    FROM berita b
    WHERE b.status = 'published' AND b.id != '{$article['id']}'
    ORDER BY b.view_count DESC
    LIMIT 5
");

// Format date function
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d M Y');
}

// Format time function
function formatTime($dateString) {
    $date = new DateTime($dateString);
    return $date->format('H:i');
}

function getFormValue($key) {
    if (isset($_SESSION['comment_status']) && isset($_SESSION['comment_status']['form_data'][$key])) {
        return htmlspecialchars($_SESSION['comment_status']['form_data'][$key]);
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['judul']) ?> - Quack Berita</title>
    <meta name="description" content="<?= htmlspecialchars($article['excerpt'] ?? substr(strip_tags($article['isi']), 0, 160)) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/article.css">
</head>
<body>

    <?php include 'layout/frontend_header.php'; ?>

    <!-- Article Header -->
    <header class="article-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Beranda</a></li>
                    <?php if (!empty($article['kategori_nama'])) : ?>
                        <li class="breadcrumb-item"><a href="category.php?slug=<?= htmlspecialchars($article['kategori_slug']) ?>"><?= htmlspecialchars($article['kategori_nama']) ?></a></li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($article['judul']) ?></li>
                </ol>
            </nav>
            
            <h1 class="article-title"><?= htmlspecialchars($article['judul']) ?></h1>
            
            <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                <?php if (!empty($article['kategori_nama'])) : ?>
                    <a href="category.php?slug=<?= htmlspecialchars($article['kategori_slug']) ?>" class="badge category-badge text-decoration-none">
                        <?= htmlspecialchars($article['kategori_nama']) ?>
                    </a>
                <?php endif; ?>
                
                <div class="meta-info">
                    <i class="far fa-user me-1"></i> <?= htmlspecialchars($article['penulis_nama']) ?>
                </div>
                
                <div class="meta-info">
                    <i class="far fa-calendar me-1"></i> <?= formatDate($article['created_at']) ?>, <?= formatTime($article['created_at']) ?> WIB
                </div>
                
                <div class="meta-info">
                    <i class="far fa-eye me-1"></i> <?= number_format($article['view_count']) ?> kali dilihat
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Article Content -->
                <div class="col-lg-8">
                    <article class="bg-white p-4 rounded shadow-sm mb-4">
                        <?php if (!empty($article['gambar_url'])) : ?>
                            <img src="<?= htmlspecialchars($article['gambar_url']) ?>" class="article-image" alt="<?= htmlspecialchars($article['judul']) ?>">
                        <?php endif; ?>
                        
                        <?php if (!empty($article['excerpt'])) : ?>
                            <div class="lead mb-4 p-3 bg-light rounded">
                                <?= htmlspecialchars($article['excerpt']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="article-content">
                            <?= $article['isi'] ?>
                        </div>
                        
                        <div class="mt-4 pt-4 border-top">
                            <h5>Tags:</h5>
                            <div class="d-flex flex-wrap mt-2">
                                <?php if (mysqli_num_rows($tagsQuery) > 0) : ?>
                                    <?php while ($tag = mysqli_fetch_assoc($tagsQuery)) : ?>
                                        <a href="tag.php?slug=<?= htmlspecialchars($tag['slug']) ?>" class="tag-link">
                                            #<?= htmlspecialchars($tag['nama']) ?>
                                        </a>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <em>Tidak ada tag</em>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div class="share-buttons">
                                <span>Bagikan:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" target="_blank" class="btn btn-sm btn-outline-primary mx-1">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>&text=<?= urlencode($article['judul']) ?>" target="_blank" class="btn btn-sm btn-outline-info mx-1">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text=<?= urlencode($article['judul'] . " - http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" target="_blank" class="btn btn-sm btn-outline-success mx-1">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                            
                            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Cetak
                            </button>
                        </div>
                    </article>
                    
                    <!-- Author Box -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; font-size: 24px;">
                                    <?= strtoupper(substr($article['penulis_nama'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1"><?= htmlspecialchars($article['penulis_nama']) ?></h5>
                                <p class="text-muted mb-2">Penulis di Quack Berita</p>
                                <p class="mb-0">Menyajikan berita dan informasi terkini dengan akurat dan terpercaya.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Articles -->
                    <?php if (mysqli_num_rows($relatedQuery) > 0) : ?>
                        <div class="mb-4">
                            <h4 class="mb-3">Artikel Terkait</h4>
                            <div class="row g-4">
                                <?php while ($related = mysqli_fetch_assoc($relatedQuery)) : ?>
                                    <div class="col-md-4">
                                        <div class="card related-card h-100">
                                            <?php if (!empty($related['gambar_url'])) : ?>
                                                <img src="<?= htmlspecialchars($related['gambar_url']) ?>" class="card-img-top related-img" alt="<?= htmlspecialchars($related['judul']) ?>">
                                            <?php else : ?>
                                                <div class="card-img-top related-img bg-secondary d-flex align-items-center justify-content-center text-white">
                                                    <i class="fas fa-newspaper fa-3x"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h5 class="card-title" style="font-size: 1rem;">
                                                    <a href="article.php?slug=<?= htmlspecialchars($related['slug']) ?>" class="text-decoration-none text-dark">
                                                        <?= htmlspecialchars($related['judul']) ?>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div class="card-footer bg-white border-0">
                                                <div class="meta-info d-flex justify-content-between">
                                                    <span><i class="far fa-user me-1"></i> <?= htmlspecialchars($related['penulis_nama']) ?></span>
                                                    <span><i class="far fa-calendar me-1"></i> <?= formatDate($related['created_at']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Comment Section -->
                    <div class="comment-section">
                        <h4 class="mb-4">Komentar</h4>
                        <p class="text-muted small">*Komentar akan dimoderasi oleh pihak pengelola sebelum ditampilkan.</p>
                        <!-- Display comment status messages -->
                        <?php if (isset($_SESSION['comment_status'])) : ?>
                            <div class="alert alert-<?= $_SESSION['comment_status']['status'] === 'success' ? 'success' : 'danger' ?> mb-4">
                                <?= $_SESSION['comment_status']['message'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Comment Form -->
                        <div class="comment-form mb-5">
                            <form action="submit_comment.php" method="POST">
                                <input type="hidden" name="berita_id" value="<?= $article['id'] ?>">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required value="<?= getFormValue('nama') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required value="<?= getFormValue('email') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="isi" class="form-label">Komentar</label>
                                    <textarea class="form-control" id="isi" name="isi" rows="5" required><?= getFormValue('isi') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                            </form>
                        </div>
                        
                        <!-- Comment List -->
                        <div id="comments">
                            <?php
                            $commentsQuery = mysqli_query($connection, "
                                SELECT * FROM komentar
                                WHERE berita_id='{$article['id']}' AND status='approved'
                                ORDER BY created_at DESC
                            ");
                            
                            if (mysqli_num_rows($commentsQuery) > 0) :
                                while ($comment = mysqli_fetch_assoc($commentsQuery)) :
                            ?>
                                <div class="comment mb-4 pb-4 border-bottom">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 20px; color: #555;">
                                                <?= strtoupper(substr($comment['nama'], 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0"><?= htmlspecialchars($comment['nama']) ?></h6>
                                                <small class="text-muted"><?= date('d M Y, H:i', strtotime($comment['created_at'])) ?></small>
                                            </div>
                                            <p class="mb-0"><?= nl2br(htmlspecialchars($comment['isi'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <div class="alert alert-light">Belum ada komentar. Jadilah yang pertama berkomentar!</div>
                            <?php endif; ?>
                        </div>
                    </div>
				</div>

                <?php
                // Clear the comment status session after displaying
                if (isset($_SESSION['comment_status'])) {
                    unset($_SESSION['comment_status']);
                }
                ?>                

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