<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Nghe Lại</title>

    <!-- CSS trang Home -->
    <link rel="stylesheet" href="public/assets/css/user/home.css" />
    <!-- Bootstrap Icons (cho icon trong view) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>

    <?php
    // Kỳ vọng các biến từ HomeController:
    // $categories, $products, $total, $page, $perPage, $totalPages, $activeCatId, $minPrice, $maxPrice, $hero

    $activeCatId = $activeCatId ?? null;
    $minPrice    = isset($minPrice) ? (float)$minPrice : null;
    $maxPrice    = isset($maxPrice) ? (float)$maxPrice : null;

    // Fallback hero (nếu controller chưa truyền)
    $hero = $hero ?? [
        'headline_left'  => 'Discover',
        'headline_mark'  => 'Vintage',
        'headline_right' => 'Music',
        'sub'            => 'Rare cassettes from the golden age of analog sound.',
        'cta_url'        => 'index.php?url=user/product/index'
    ];

    // Header chung
    require_once __DIR__ . "/layouts/header.php";
    ?>

    <div class="home-wrap">

        <!-- ========== SIDEBAR ========== -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">CATEGORIES</div>

                <a class="cat-item <?= $activeCatId ? '' : 'is-active' ?>" href="index.php?url=user/home">
                    <i class="bi bi-grid"></i>
                    <span>All</span>
                    <span class="cat-count"><?= number_format((int)($total ?? 0)) ?></span>
                </a>

                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $c): ?>
                        <a class="cat-item <?= ($activeCatId == $c['category_id']) ? 'is-active' : '' ?>"
                            href="index.php?url=user/home&category=<?= urlencode($c['category_id']) ?>">
                            <i class="bi bi-disc"></i>
                            <span><?= htmlspecialchars($c['category_name']) ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="muted" style="padding:8px 2px;">Chưa có danh mục</div>
                <?php endif; ?>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">PRICE RANGE</div>
                <form class="price-form" method="get" action="index.php">
                    <input type="hidden" name="url" value="user/home" />
                    <?php if ($activeCatId): ?>
                        <input type="hidden" name="category" value="<?= htmlspecialchars($activeCatId) ?>" />
                    <?php endif; ?>
                    <input class="price-input" type="number" name="min_price" step="1000" placeholder="Min price (đ)"
                        value="<?= $minPrice !== null ? (int)$minPrice : '' ?>" />
                    <input class="price-input" type="number" name="max_price" step="1000" placeholder="Max price (đ)"
                        value="<?= $maxPrice !== null ? (int)$maxPrice : '' ?>" />
                    <button class="btn-primary" type="submit">Apply filter</button>
                </form>
            </div>
        </aside>

        <!-- ========== MAIN ========== -->
        <main class="main">

            <!-- HERO -->
            <section class="hero">
                <div class="hero-inner">
                    <h1 class="hero-title">
                        <span><?= htmlspecialchars($hero['headline_left'] ?? '') ?></span>
                        <mark><?= htmlspecialchars($hero['headline_mark'] ?? '') ?></mark>
                        <span><?= htmlspecialchars($hero['headline_right'] ?? '') ?></span>
                    </h1>
                    <?php if (!empty($hero['sub'])): ?>
                        <p class="hero-sub"><?= htmlspecialchars($hero['sub']) ?></p>
                    <?php endif; ?>
                    <a class="hero-cta" href="<?= htmlspecialchars($hero['cta_url']) ?>">
                        <i class="bi bi-play-fill"></i> Shop Collection
                    </a>
                </div>
            </section>

            <!-- FEATURED -->
            <section class="section">
                <h2 class="section-title">FEATURED ALBUMS</h2>

                <?php if (!empty($products)): ?>
                    <div class="grid">
                        <?php foreach ($products as $p): ?>
                            <article class="card">
                                <a class="card-media" href="index.php?url=user/product/detail/<?= urlencode($p['product_id']) ?>">
                                    <?php if (!empty($p['image_url'] ?? $p['image'])): ?>
                                        <img src="public/uploads/products/<?= htmlspecialchars($p['image_url'] ?? $p['image']) ?>"
                                            alt="<?= htmlspecialchars($p['name'] ?? $p['Name'] ?? 'Product') ?>">
                                    <?php else: ?>
                                        <div class="media-fallback"><i class="bi bi-music-note-beamed"></i></div>
                                    <?php endif; ?>
                                </a>

                                <div class="card-body">
                                    <!-- 1) Tên sản phẩm (đầu) -->
                                    <h3 class="card-name">
                                        <a href="index.php?url=user/product/detail/<?= urlencode($p['product_id']) ?>">
                                            <?= htmlspecialchars($p['name'] ?? $p['Name'] ?? 'No name') ?>
                                        </a>
                                    </h3>

                                    <!-- 2) Tên tác giả / nghệ sĩ (ngay dưới tên) -->
                                    <div class="card-artist">
                                        <?= htmlspecialchars($p['maker'] ?? $p['artist'] ?? $p['artist_brand'] ?? 'Artist/Label') ?>
                                    </div>

                                    <!-- 3) Giá (sẽ tự đẩy xuống gần đáy nhờ margin-top:auto trong CSS) -->
                                    <div class="card-price">
                                        <?= number_format((float)($p['price'] ?? $p['Price'] ?? 0), 0, ',', '.') ?> đ
                                    </div>

                                    <!-- 4) Nút đặt ở đáy, full width -->
                                    <div class="card-actions">
                                        <a class="btn-add" href="index.php?url=user/cart/add/<?= urlencode($p['product_id']) ?>">
                                            Add to cart
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (!empty($totalPages) && $totalPages > 1): ?>
                        <nav class="pagination">
                            <?php
                            // giữ filter khi chuyển trang
                            $qs = ['url' => 'user/home'];
                            if ($activeCatId)       $qs['category']   = $activeCatId;
                            if ($minPrice !== null) $qs['min_price']  = (int)$minPrice;
                            if ($maxPrice !== null) $qs['max_price']  = (int)$maxPrice;
                            ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php
                                $qs['page'] = $i;
                                $href = 'index.php?' . http_build_query($qs);
                                ?>
                                <a class="page <?= $i == ($page ?? 1) ? 'is-active' : '' ?>" href="<?= $href ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        </nav>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="empty">No products matched.</div>
                <?php endif; ?>
            </section>

        </main>
    </div>
    <?php require_once __DIR__ . "/layouts/footer.php";
