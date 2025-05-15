<?php
require_once './helper/connection.php';

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get categories for navigation
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
    <title>Kontak Kami - Quack Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/frontend/home.css">
    <link rel="stylesheet" href="assets/css/frontend/contact.css">
</head>
<body>

    <?php include 'layout/frontend_header.php'; ?>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">Hubungi Kami</h1>
                    <p class="lead">Kami senang mendengar dari Anda. Kirimkan pertanyaan, saran, atau masukan Anda melalui formulir di bawah ini.</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Contact Info -->
    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Alamat</h4>
                    <p>Jl. Media Informasi No. 123<br>Jakarta Pusat, 10110</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4>Telepon</h4>
                    <p>(021) 123-4567<br>0812-3456-7890</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Email</h4>
                    <p>info@portalberita.com<br>redaksi@portalberita.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mb-5">
        <h2 class="section-title mb-4">Pertanyaan Yang Sering Diajukan</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                        Bagaimana cara berlangganan newsletter Quack Berita?
                    </button>
                </h2>
                <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Anda dapat berlangganan newsletter kami dengan mengisi formulir newsletter yang tersedia di halaman beranda atau dengan mengirimkan email ke newsletter@portalberita.com dengan subjek "Langganan Newsletter".
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        Bagaimana cara mengirimkan berita atau artikel untuk dipublikasikan?
                    </button>
                </h2>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Untuk mengirimkan berita atau artikel, silakan kirimkan naskah lengkap ke email redaksi@portalberita.com. Tim redaksi kami akan meninjau dan menghubungi Anda jika artikel tersebut memenuhi kriteria publikasi kami.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        Apakah Quack Berita menerima kerja sama iklan atau sponsor konten?
                    </button>
                </h2>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ya, kami terbuka untuk kerja sama iklan dan sponsor konten. Silakan hubungi tim pemasaran kami melalui iklan@portalberita.com untuk mendiskusikan lebih lanjut mengenai paket iklan dan harga.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        Bagaimana jika saya menemukan kesalahan dalam artikel yang dipublikasikan?
                    </button>
                </h2>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Kami menghargai umpan balik dari pembaca. Jika Anda menemukan kesalahan dalam artikel kami, silakan laporkan melalui email koreksi@portalberita.com dengan menyertakan judul artikel dan detail kesalahan yang ditemukan.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'layout/frontend_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>