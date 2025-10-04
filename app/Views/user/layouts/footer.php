<link rel="stylesheet" href="public/assets/css/user/footer.css">

<!-- ===== FOOTER (đơn giản) ===== -->
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="footer-logo">RETRO<br>TAPES</div>
            <p class="muted">
                Bringing vintage music back to life. Discover rare cassettes curated with love for the authentic analog sound.
            </p>
            <div class="footer-social">
                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" aria-label="Youtube"><i class="bi bi-youtube"></i></a>
            </div>
        </div>

        <div>
            <div class="footer-title">Shop</div>
            <a href="index.php?url=user/product/new">New Arrivals</a>
            <a href="index.php?url=user/product/best">Best Sellers</a>
            <a href="index.php?url=user/product/sale">Sale Items</a>
            <a href="#">Gift Cards</a>
        </div>

        <div>
            <div class="footer-title">Categories</div>
            <?php if (!empty($categories)): ?>
                <?php foreach (array_slice($categories, 0, 6) as $c): ?>
                    <a href="index.php?url=user/home&category=<?= urlencode($c['category_id']) ?>">
                        <?= htmlspecialchars($c['category_name']) ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="muted">Updating...</span>
            <?php endif; ?>
        </div>

        <div>
            <div class="footer-title">Support</div>
            <a href="#">Help Center</a>
            <a href="#">Shipping Info</a>
            <a href="#">Returns</a>
            <a href="#">Contact Us</a>
        </div>
    </div>

    <div class="footer-bottom">
        © <?= date('Y') ?> Retro Tapes — Bringing vintage music back to life.
    </div>
</footer>

</body>

</html>