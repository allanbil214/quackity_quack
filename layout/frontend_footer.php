    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4 class="footer-title">QUACK BERITA</h4>
                    <p>Platform berita terpercaya yang menyajikan informasi aktual dan terkini untuk Anda.</p>
                    <div class="mt-3">
                        <a href="https://www.facebook.com" class="social-icon" target="_blank"><i class="fab fa-facebook-f text-white"></i></a>
                        <a href="https://www.twitter.com" class="social-icon" target="_blank"><i class="fab fa-twitter text-white"></i></a>
                        <a href="https://www.instagram.com" class="social-icon" target="_blank"><i class="fab fa-instagram text-white"></i></a>
                        <a href="https://www.linkedin.com" class="social-icon" target="_blank"><i class="fab fa-linkedin-in text-white"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="footer-title">Kategori</h5>
                    <ul class="list-unstyled">
                        <?php foreach (array_slice($categories, 0, 5) as $category) : ?>
                            <li class="mb-2">
                                <a href="category.php?slug=<?= htmlspecialchars($category['slug']) ?>" class="footer-link">
                                    <?= htmlspecialchars($category['nama']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="footer-title">Tautan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="home.php" class="footer-link">Beranda</a></li>
                        <li class="mb-2"><a href="about.php" class="footer-link">Tentang Kami</a></li>
                        <li class="mb-2"><a href="contact.php" class="footer-link">Kontak</a></li>
                        <li class="mb-2"><a href="privacy-policy.php" class="footer-link">Kebijakan Privasi</a></li>
                        <li class="mb-2"><a href="terms.php" class="footer-link">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="footer-title">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Media Informasi No. 123, Jakarta</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (021) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@quackberita.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright py-3 mt-4">
            <div class="container text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> Quack Berita. All rights reserved.</p>
            </div>
        </div>
    </footer>
