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
    SELECT b.id, b.judul, b.slug, b.view_count
    FROM berita b
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
    <title>Kebijakan Privasi - Quack Berita</title>
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
                    <h1 class="display-4 fw-bold">Kebijakan Privasi</h1>
                    <p class="lead">Semua berita yang ditampilkan di situs ini telah melalui proses kurasi untuk memastikan keakuratan dan relevansinya.</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Privacy Policy Content -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <article class="privacy-policy">
                                <h2>Kebijakan Privasi Quack Berita</h2>
                                <p class="lead">Terakhir diperbarui: 1 Mei 2025</p>
                                
                                <div class="mb-4">
                                    <p>Selamat datang di Quack Berita. Kami berkomitmen untuk melindungi privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi pribadi Anda saat Anda menggunakan website kami.</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>1. Informasi yang Kami Kumpulkan</h3>
                                    <p>Kami mengumpulkan beberapa jenis informasi dari pengguna website kami:</p>
                                    <ul>
                                        <li><strong>Informasi Pribadi</strong>: Nama, alamat email, dan informasi kontak lainnya yang Anda berikan saat mendaftar atau berkomentar.</li>
                                        <li><strong>Informasi Penggunaan</strong>: Data tentang bagaimana Anda berinteraksi dengan website kami, termasuk artikel yang Anda baca, waktu kunjungan, dan halaman yang dilihat.</li>
                                        <li><strong>Informasi Perangkat</strong>: Data teknis seperti alamat IP, jenis browser, perangkat, dan sistem operasi yang Anda gunakan.</li>
                                        <li><strong>Cookies</strong>: Kami menggunakan cookies dan teknologi pelacakan serupa untuk meningkatkan pengalaman pengguna dan mengumpulkan data statistik.</li>
                                    </ul>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>2. Bagaimana Kami Menggunakan Informasi Anda</h3>
                                    <p>Kami menggunakan informasi yang dikumpulkan untuk:</p>
                                    <ul>
                                        <li>Menyediakan, memelihara, dan meningkatkan layanan kami</li>
                                        <li>Memproses dan mengelola komentar serta interaksi pengguna</li>
                                        <li>Mengirimkan pemberitahuan, pembaruan, dan informasi yang Anda minta</li>
                                        <li>Menganalisis tren penggunaan dan memperbaiki pengalaman pengguna</li>
                                        <li>Mencegah aktivitas penipuan dan melindungi keamanan website</li>
                                        <li>Mematuhi kewajiban hukum</li>
                                    </ul>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>3. Berbagi Informasi dengan Pihak Ketiga</h3>
                                    <p>Kami tidak akan menjual, memperdagangkan, atau menyewakan informasi pribadi pengguna kepada pihak lain. Namun, kami dapat membagikan informasi dalam situasi berikut:</p>
                                    <ul>
                                        <li>Dengan penyedia layanan pihak ketiga yang membantu operasional website kami</li>
                                        <li>Untuk mematuhi hukum atau menanggapi proses hukum</li>
                                        <li>Untuk melindungi hak, properti, atau keselamatan kami, pengguna kami, atau orang lain</li>
                                        <li>Dalam kasus reorganisasi, merger, penjualan, atau transfer aset perusahaan</li>
                                    </ul>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>4. Keamanan Data</h3>
                                    <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi informasi pribadi Anda dari akses yang tidak sah, penyalahgunaan, atau kebocoran. Namun, tidak ada metode transmisi internet atau metode penyimpanan elektronik yang 100% aman.</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>5. Cookies dan Teknologi Pelacakan</h3>
                                    <p>Website kami menggunakan cookies dan teknologi pelacakan serupa untuk mengumpulkan dan menyimpan informasi saat Anda mengunjungi website kami. Anda dapat mengatur browser Anda untuk menolak semua atau beberapa cookies, atau untuk memberi tahu Anda saat cookies sedang dikirim.</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>6. Hak Pengguna</h3>
                                    <p>Anda memiliki hak untuk:</p>
                                    <ul>
                                        <li>Mengakses informasi pribadi yang kami miliki tentang Anda</li>
                                        <li>Meminta koreksi informasi yang tidak akurat</li>
                                        <li>Meminta penghapusan data Anda (dalam kondisi tertentu)</li>
                                        <li>Membatasi atau menolak pemrosesan data Anda</li>
                                        <li>Meminta portabilitas data Anda</li>
                                    </ul>
                                    <p>Untuk menggunakan hak ini, silakan hubungi kami melalui informasi kontak di bawah.</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>7. Kebijakan untuk Anak-anak</h3>
                                    <p>Website kami tidak ditujukan untuk anak-anak di bawah usia 13 tahun. Kami tidak secara sengaja mengumpulkan informasi pribadi dari anak-anak di bawah 13 tahun. Jika Anda adalah orang tua atau wali dan percaya bahwa anak Anda telah memberikan kami informasi pribadi, silakan hubungi kami.</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>8. Perubahan pada Kebijakan Privasi Ini</h3>
                                    <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Kami akan memberi tahu Anda tentang perubahan dengan memposting kebijakan baru di halaman ini dan memperbarui tanggal "terakhir diperbarui" di bagian atas. Anda disarankan untuk meninjau Kebijakan Privasi ini secara berkala.</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h3>9. Hubungi Kami</h3>
                                    <p>Jika Anda memiliki pertanyaan atau kekhawatiran tentang Kebijakan Privasi ini, silakan hubungi kami di:</p>
                                    <address>
                                        <strong>Quack Berita</strong><br>
                                        Email: privacy@portalberita.com<br>
                                        Telepon: (021) 123-4567<br>
                                        Alamat: Jl. Media Utama No. 123, Jakarta
                                    </address>
                                </div>
                            </article>
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
                </div>
            </div>
        </div>
    </section>

    <?php include 'layout/frontend_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>