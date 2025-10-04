<?php
// EXPECT: $product, $related, $categories
if (session_status() === PHP_SESSION_NONE) session_start();

$id    = $product['product_id'] ?? $product['id'] ?? 0;
$name  = $product['name'] ?? $product['Name'] ?? 'Sản phẩm';
$price = (float)($product['price'] ?? $product['Price'] ?? 0);
$maker = $product['maker'] ?? $product['artist_brand'] ?? $product['artist'] ?? 'Không rõ';
$desc  = $product['description'] ?? $product['Description'] ?? '';
$img   = $product['image'] ?? $product['image_url'] ?? '';

$stock   = (int)($product['stock'] ?? $product['quantity'] ?? $product['qty'] ?? $product['in_stock'] ?? 0);
$maxBuy  = max(0, $stock - 1);
$canBuy  = $maxBuy > 0;

$loggedIn = !empty($_SESSION['user']) || !empty($_SESSION['user_id']);

require_once dirname(__DIR__) . '/layouts/header.php';
?>
<link rel="stylesheet" href="public/assets/css/user/product.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<main class="pd-wrap">
    <nav class="pd-back">
        <a class="btn-ghost" href="index.php?url=user/home"><i class="bi bi-arrow-left"></i> Quay lại</a>
    </nav>

    <section class="pd-main">
        <div class="pd-media">
            <figure class="media-frame">
                <?php if ($img): ?>
                    <img src="public/uploads/products/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($name) ?>">
                <?php else: ?>
                    <div class="media-fallback"><i class="bi bi-music-note-beamed"></i></div>
                <?php endif; ?>
                <button class="zoom-btn" type="button"><i class="bi bi-zoom-in"></i> Phóng to</button>
            </figure>
        </div>

        <aside class="pd-info">
            <div class="pd-meta">BĂNG CASSETTE</div>
            <h1 class="pd-title"><?= htmlspecialchars($name) ?></h1>

            <a class="pd-maker" href="index.php?url=user/product/search&q=<?= urlencode($maker) ?>">
                <?= htmlspecialchars($maker) ?>
            </a>

            <div class="pd-rating muted">
                <i class="bi bi-star"></i>
                <span>Đánh giá sẽ được cập nhật sau</span>
            </div>

            <div class="pd-price"><?= number_format($price, 0, ',', '.') ?> đ</div>

            <div class="pd-stock">
                <i class="bi bi-box-seam"></i>
                <?php if ($stock > 1): ?>
                    Còn <b><?= number_format($stock) ?></b> sản phẩm
                <?php elseif ($stock == 1): ?>
                    Chỉ còn <b>1</b> sản phẩm &middot; Tạm thời không nhận đặt thêm
                <?php else: ?>
                    <span class="muted">Hết hàng</span>
                <?php endif; ?>
            </div>

            <p class="pd-blurb">
                <?= $desc ? nl2br(htmlspecialchars($desc)) : 'Băng đẹp, âm analog ấm. Phù hợp mọi bộ sưu tập nhạc xưa.' ?>
            </p>

            <div class="pd-qty">
                <label>Số lượng:</label>
                <div class="qty-box" data-min="1" data-max="<?= $canBuy ? (int)$maxBuy : 1 ?>">
                    <button class="qty-minus" type="button" aria-label="Giảm" <?= ($canBuy && $loggedIn) ? '' : 'disabled' ?>><i class="bi bi-dash"></i></button>
                    <input class="qty-input" type="number"
                        value="<?= ($canBuy && $loggedIn) ? 1 : 0 ?>"
                        min="1" max="<?= $canBuy ? (int)$maxBuy : 1 ?>"
                        inputmode="numeric" <?= ($canBuy && $loggedIn) ? '' : 'disabled' ?>>
                    <button class="qty-plus" type="button" aria-label="Tăng" <?= ($canBuy && $loggedIn) ? '' : 'disabled' ?>><i class="bi bi-plus"></i></button>
                </div>
            </div>

            <?php if ($loggedIn && $canBuy): ?>
                <form class="pd-actions" method="post" action="index.php?url=user/cart/add/<?= urlencode($id) ?>">
                    <input type="hidden" name="quantity" value="1" id="hiddenQty">
                    <!-- THÊM XONG Ở LẠI TRANG NÀY -->
                    <input type="hidden" name="back" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <button class="btn-add" type="submit">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                    </button>
                </form>
            <?php elseif (!$loggedIn): ?>
                <div class="pd-actions">
                    <a class="btn-add" href="#"
                        data-require-login
                        data-msg="Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                    </a>
                </div>
            <?php else: ?>
                <form class="pd-actions">
                    <button class="btn-add" type="button" disabled aria-disabled="true" title="Chỉ còn 1 chiếc - tạm dừng đặt">
                        <i class="bi bi-info-circle"></i> Tạm dừng đặt thêm
                    </button>
                    <div class="muted" style="margin-top:8px">
                        <i class="bi bi-info-circle"></i> Chỉ còn 1 chiếc trong kho nên tạm thời không nhận thêm đơn. Vui lòng liên hệ để giữ hàng.
                    </div>
                </form>
            <?php endif; ?>

            <ul class="pd-quick">
                <li><i class="bi bi-truck"></i> Giao nhanh 24–48h nội thành</li>
                <li><i class="bi bi-arrow-repeat"></i> Đổi trả 7 ngày nếu lỗi</li>
                <li><i class="bi bi-shield-check"></i> Hàng kiểm tra – đóng gói kỹ</li>
            </ul>
        </aside>
    </section>

    <?php if (!empty($related)): ?>
        <section class="pd-related">
            <h2 class="section-title">Có thể bạn cũng thích</h2>
            <div class="grid">
                <?php foreach ($related as $r):
                    $rid   = $r['product_id'] ?? $r['id'] ?? 0;
                    $rname = $r['name'] ?? $r['Name'] ?? 'Sản phẩm';
                    $rimg  = $r['image'] ?? $r['image_url'] ?? '';
                    $rpr   = (float)($r['price'] ?? $r['Price'] ?? 0);
                    $rmk   = $r['maker'] ?? $r['artist_brand'] ?? $r['artist'] ?? '—';
                ?>
                    <article class="card">
                        <a class="card-media" href="index.php?url=user/product/detail/<?= urlencode($rid) ?>">
                            <?php if ($rimg): ?>
                                <img src="public/uploads/products/<?= htmlspecialchars($rimg) ?>" alt="<?= htmlspecialchars($rname) ?>">
                            <?php else: ?>
                                <div class="media-fallback"><i class="bi bi-music-note-beamed"></i></div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <h3 class="card-name">
                                <a href="index.php?url=user/product/detail/<?= urlencode($rid) ?>"><?= htmlspecialchars($rname) ?></a>
                            </h3>
                            <div class="card-artist"><?= htmlspecialchars($rmk) ?></div>
                            <div class="card-price"><?= number_format($rpr, 0, ',', '.') ?> đ</div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<script src="public/assets/js/user/product.js"></script>
<script src="public/assets/js/user/RequireLogin.js"></script>
<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>