<?php
// EXPECT: $categories = [...]; // lấy từ controller
$user   = $_SESSION['user'] ?? null;
$avatar = $user['avatar'] ?? null;
?>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="public/assets/css/user/header.css">

<header class="site-header">
    <div class="site-header__inner">

        <!-- LEFT -->
        <div class="header-left">
            <!-- Burger (mobile) -->
            <button class="menu-toggle" aria-label="Open menu">
                <span></span><span></span><span></span>
            </button>

            <!-- Brand -->
            <a href="index.php?url=user/home" class="brand" aria-label="Home">
                <img class="brand__logo" src="public/uploads/logo.png" alt="Logo">
                <strong class="brand__name">NGHE LẠI</strong>
            </a>

            <!-- Main nav -->
            <nav class="main-nav">
                <a href="index.php?url=user/home">Home</a>

                <!-- CATEGORIES as MEGA PANEL (no caret) -->
                <div class="nav-mega">
                    <button class="nav-mega__btn" type="button">Categories</button>

                    <div class="nav-mega__panel">
                        <div class="nav-mega__title">Browse categories</div>
                        <ul class="mega-list">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $c): ?>
                                    <li>
                                        <a href="index.php?url=user/home&category=<?= urlencode($c['category_id']) ?>">
                                            <i class="bi bi-disc"></i>
                                            <?= htmlspecialchars($c['category_name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><em class="nav-dropdown__empty">Chưa có danh mục</em></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <a href="index.php?url=user/product/new">New Arrivals</a>
                <a href="index.php?url=user/product/sale">Sale</a>
                <a href="index.php?url=user/page/about">About</a>
                <a href="index.php?url=user/page/contact">Contact</a>
            </nav>
        </div>

        <!-- CENTER: Search -->
        <div class="header-center">
            <form class="header-search" action="index.php" method="get" role="search">
                <input type="hidden" name="url" value="user/product/search">
                <i class="bi bi-search header-search__icon" aria-hidden="true"></i>
                <input class="header-search__input" type="search" name="q"
                    placeholder="Search cassettes..." autocomplete="off">
            </form>
        </div>

        <!-- RIGHT -->
        <div class="header-right">
            <!-- Search icon (mobile) -->
            <button class="icon-btn js-open-search" aria-label="Search"><i class="bi bi-search"></i></button>

            <!-- Cart (không hiện số) -->
            <a class="cart" href="index.php?url=user/cart" aria-label="Cart">
                <i class="bi bi-cart2"></i>
                <!-- <span class="cart__badge" id="cartCount">3</span> -->
            </a>

            <!-- Avatar / Login -->
            <?php if ($user): ?>
                <div class="user">
                    <button class="user__btn avatar" type="button" aria-label="Account menu">
                        <img src="<?= $avatar ? 'public/uploads/avatars/' . htmlspecialchars($avatar)
                                        : 'public/assets/img/avatar-default.png' ?>" alt="Avatar">
                    </button>

                    <!-- simple menu -->
                    <div class="user-menu" id="userMenu">
                        <div class="user-menu__header">
                            <div class="user-menu__avatar">
                                <img src="<?= $avatar ? 'public/uploads/avatars/' . htmlspecialchars($avatar)
                                                : 'public/assets/img/avatar-default.png' ?>" alt="">
                            </div>
                            <div>
                                <div class="user-menu__name"><?= htmlspecialchars($user['fullname'] ?? $user['username'] ?? 'User') ?></div>
                                <?php if (!empty($user['email'])): ?>
                                    <div class="user-menu__mail"><?= htmlspecialchars($user['email']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="user-menu__list">
                            <a href="index.php?url=user/account"><i class="bi bi-person"></i> Account</a>
                            <a href="index.php?url=user/orders"><i class="bi bi-receipt"></i> Orders</a>
                            <a class="danger" href="index.php?url=user/Auth/logout"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a class="login-btn" href="index.php?url=user/Auth/login">LOGIN</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Drawer (mobile) -->
<aside class="drawer" aria-hidden="true">
    <div class="drawer__head">
        <span>MENU</span>
        <button class="drawer__close" aria-label="Close menu"><i class="bi bi-x-lg"></i></button>
    </div>

    <nav class="drawer__nav">
        <a href="index.php?url=user/home"><i class="bi bi-house"></i> Home</a>
        <a href="index.php?url=user/product/new"><i class="bi bi-stars"></i> New Arrivals</a>
        <a href="index.php?url=user/product/sale"><i class="bi bi-tag"></i> Sale</a>
        <a href="index.php?url=user/page/about"><i class="bi bi-info-circle"></i> About</a>
        <a href="index.php?url=user/page/contact"><i class="bi bi-envelope"></i> Contact</a>
    </nav>

    <hr class="drawer__sep">

    <div class="drawer__title">CATEGORIES</div>
    <ul class="drawer__cats">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $c): ?>
                <li>
                    <a href="index.php?url=user/home&category=<?= urlencode($c['category_id']) ?>">
                        <i class="bi bi-music-note-beamed"></i>
                        <?= htmlspecialchars($c['category_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li><em class="muted">Chưa có danh mục</em></li>
        <?php endif; ?>
    </ul>
</aside>
<div class="drawer-backdrop"></div>

<script src="public/assets/js/user/header.js"></script>