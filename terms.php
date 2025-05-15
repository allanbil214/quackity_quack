<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get categories for sidebar
$categoriesQuery = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");
$categories = [];
while ($category = mysqli_fetch_assoc($categoriesQuery)) {
    $categories[] = $category;
}

// Get popular articles for sidebar
$popularQuery = mysqli_query($connection, "
    SELECT b.id, b.judul, b.slug, b.view_count, b.created_at
    FROM berita b
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
    <title>Syarat dan Ketentuan - Quack Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/terms.css">
    <link rel="stylesheet" href="assets/css/frontend/about.css">
</head>
<body>

<?php include 'layout/frontend_header.php'; ?>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                <h1 class="display-4 fw-bold">Syarat dan Ketentuan</h1>
                    <p class="lead">Halaman ini menampilkan semua berita yang tersedia beserta informasi penting terkait Syarat dan Ketentuan.</p>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Terms Content -->
                <div class="col-lg-8">
                    <div class="terms-section">
                        <h2>Syarat dan Ketentuan Penggunaan</h2>
                        <div class="terms-last-updated">Terakhir diperbarui: 1 Mei 2025</div>
                        
                        <div class="terms-content">
                            <p>Selamat datang di Quack Berita kami. Halaman ini berisi syarat dan ketentuan penggunaan yang mengatur penggunaan Anda atas layanan kami. Dengan mengakses dan menggunakan situs ini, Anda menyetujui untuk terikat oleh syarat dan ketentuan ini. Jika Anda tidak setuju dengan salah satu ketentuan ini, Anda tidak diperkenankan menggunakan atau mengakses situs ini.</p>
                            
                            <h3>1. Penggunaan Konten</h3>
                            <p>Seluruh konten yang tersedia di situs ini, termasuk tapi tidak terbatas pada teks, grafik, logo, ikon, gambar, klip audio, unduhan digital, kompilasi data, dan perangkat lunak, adalah milik Quack Berita atau penyedia konten dan dilindungi oleh undang-undang hak cipta Indonesia dan internasional.</p>
                            <p>Anda diperbolehkan untuk:</p>
                            <ul>
                                <li>Melihat, membaca, dan mendownload materi dari situs ini untuk penggunaan pribadi, non-komersial.</li>
                                <li>Berbagi tautan artikel melalui media sosial dengan atribusi yang tepat.</li>
                            </ul>
                            <p>Anda tidak diperbolehkan untuk:</p>
                            <ul>
                                <li>Memodifikasi atau menyalin materi dari situs ini.</li>
                                <li>Menggunakan materi untuk tujuan komersial atau untuk tampilan publik.</li>
                                <li>Mencoba melakukan rekayasa balik perangkat lunak apa pun yang terdapat di situs ini.</li>
                                <li>Menghapus hak cipta atau notasi kepemilikan lainnya dari materi.</li>
                                <li>Mentransfer materi ke orang lain atau "mencerminkan" materi di server lain.</li>
                            </ul>
                            
                            <h3>2. Komentar dan Konten Pengguna</h3>
                            <p>Saat Anda memberikan komentar atau mengirimkan konten ke situs kami, Anda memberikan Quack Berita hak non-eksklusif, bebas royalti, abadi, dan dapat disublisensikan untuk menggunakan, mereproduksi, mengedit, dan mengizinkan orang lain untuk menggunakan, mereproduksi, dan mengedit konten tersebut dalam bentuk apa pun, media, atau teknologi yang sekarang dikenal atau dikembangkan kemudian.</p>
                            <p>Pengguna bertanggung jawab penuh atas konten yang mereka posting. Quack Berita berhak menghapus konten yang melanggar ketentuan kami, termasuk:</p>
                            <ul>
                                <li>Konten yang bersifat menyinggung, melecehkan, atau mengancam.</li>
                                <li>Konten yang melanggar hak kekayaan intelektual pihak ketiga.</li>
                                <li>Informasi pribadi yang sensitif.</li>
                                <li>Konten yang melanggar hukum atau mempromosikan kegiatan ilegal.</li>
                                <li>Spam, iklan yang tidak diminta, atau konten yang tidak relevan.</li>
                            </ul>
                            
                            <h3>3. Penafian Tanggung Jawab</h3>
                            <p>Materi di situs Quack Berita disediakan "sebagaimana adanya". Quack Berita tidak memberikan jaminan, tersurat maupun tersirat, dan dengan ini menyangkal dan meniadakan semua jaminan lainnya, termasuk tanpa batasan, jaminan tersirat atau kondisi yang dapat diperdagangkan, kesesuaian untuk tujuan tertentu, atau non-pelanggaran kekayaan intelektual atau pelanggaran hak lainnya.</p>
                            <p>Selanjutnya, Quack Berita tidak menjamin atau membuat pernyataan apa pun mengenai keakuratan, kemungkinan hasil, atau keandalan penggunaan materi di situs web-nya atau yang berkaitan dengan materi tersebut atau di situs apa pun yang ditautkan ke situs ini.</p>
                            
                            <h3>4. Batasan</h3>
                            <p>Dalam keadaan apa pun, Quack Berita atau pemasoknya tidak bertanggung jawab atas kerugian (termasuk, tanpa batasan, kerugian akibat kehilangan data atau keuntungan, atau karena gangguan bisnis) yang timbul dari penggunaan atau ketidakmampuan untuk menggunakan materi di situs Quack Berita, bahkan jika Quack Berita atau perwakilan resmi Quack Berita telah diberitahu secara lisan atau tertulis tentang kemungkinan kerugian tersebut.</p>
                            
                            <h3>5. Privasi</h3>
                            <p>Kebijakan Privasi kami, yang menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan, adalah bagian dari Syarat dan Ketentuan ini.</p>
                            
                            <h3>6. Perubahan Syarat dan Ketentuan</h3>
                            <p>Quack Berita dapat merevisi syarat dan ketentuan ini untuk situs webnya kapan saja tanpa pemberitahuan. Dengan menggunakan situs ini, Anda setuju untuk terikat dengan versi terbaru dari syarat dan ketentuan ini.</p>
                            
                            <h3>7. Hukum yang Berlaku</h3>
                            <p>Syarat dan ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Indonesia dan Anda secara tidak dapat dibatalkan tunduk pada yurisdiksi eksklusif pengadilan di negara tersebut.</p>
                            
                            <h3>8. Hubungi Kami</h3>
                            <p>Jika Anda memiliki pertanyaan tentang Syarat dan Ketentuan kami, silakan hubungi kami melalui:</p>
                            <ul>
                                <li>Email: info@portalberita.com</li>
                                <li>Telepon: +62-21-1234567</li>
                                <li>Alamat: Jl. Berita No. 123, Jakarta Pusat, Indonesia</li>
                            </ul>
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
                    
                    <!-- Help Links -->
                    <div class="card mb-4">
                        <div class="card-header bg-white border-0">
                            <h4 class="section-title">Halaman Bantuan</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <a href="about.php" class="text-decoration-none">
                                        <i class="fas fa-info-circle me-2"></i> Tentang Kami
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="contact.php" class="text-decoration-none">
                                        <i class="fas fa-envelope me-2"></i> Kontak Kami
                                    </a>
                                </li>
                                <li class="list-group-item bg-light">
                                    <a href="terms.php" class="text-decoration-none fw-bold">
                                        <i class="fas fa-file-contract me-2"></i> Syarat dan Ketentuan
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="privacy.php" class="text-decoration-none">
                                        <i class="fas fa-user-shield me-2"></i> Kebijakan Privasi
                                    </a>
                                </li>
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