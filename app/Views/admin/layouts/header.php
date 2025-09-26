<?php
// Lấy URL hiện tại
$currentUrl = $_GET['url'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nghe Lai Admin</title>

    <!-- Bootstrap CSS + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

    <!-- Your styles -->
    <link rel="stylesheet" href="public/assets/css/base.css" />
    <link rel="stylesheet" href="public/assets/css/admin.css" />

    <!-- Favicon -->
    <link rel="icon" href="public/assets/images/ui/favicon.png" />
</head>

<body>
    <!-- HEADER -->
    <header class="topbar">
        <div class="topbar-row">
            <div class="top-left brand">
                <div class="logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="18" height="18" role="img" aria-label="Logo">
                        <path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5Z"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="brand-name">Nghe Lai</span>
            </div>

            <form id="searchForm" class="search" role="search" aria-label="Tìm kiếm">
                <input id="searchInput" type="search" placeholder="Tìm kiếm..." autocomplete="off" />
            </form>

            <div class="top-right">
                <button id="btnBell" class="icon-btn" type="button" aria-expanded="false" aria-controls="notifyPanel" title="Thông báo">
                    <i class="bi bi-bell"></i>
                </button>
                <div class="avatar" aria-label="Avatar">AU</div>
                <span class="user-name">Admin User</span>
            </div>
        </div>

        <!-- MENU NGANG -->
        <nav id="topnav" class="topnav">
            <a href="index.php?url=admin/Dashboard/index" class="nav-item <?= strpos($currentUrl, 'admin/Dashboard') === 0 ? 'active' : '' ?>" title="Tổng quan">
                <i class="bi bi-house"></i> <span>Tổng quan</span>
            </a>
            <a href="index.php?url=admin/Product/index" class="nav-item <?= strpos($currentUrl, 'admin/Product') === 0 ? 'active' : '' ?>" title="Sản phẩm">
                <i class="bi bi-box-seam"></i> <span>Sản phẩm</span>
            </a>
            <a href="index.php?url=admin/Category/index" class="nav-item <?= strpos($currentUrl, 'admin/Category') === 0 ? 'active' : '' ?>" title="Danh mục">
                <i class="bi bi-collection"></i> <span>Danh mục</span>
            </a>
            <a href="index.php?url=admin/Order/index" class="nav-item <?= strpos($currentUrl, 'admin/Order') === 0 ? 'active' : '' ?>" title="Đơn hàng">
                <i class="bi bi-receipt"></i> <span>Đơn hàng</span>
            </a>
            <a href="index.php?url=admin/Employee/index" class="nav-item <?= strpos($currentUrl, 'admin/Employee') === 0 ? 'active' : '' ?>" title="Nhân viên">
                <i class="bi bi-person-badge"></i> <span>Nhân viên</span>
            </a>
            <a href="index.php?url=admin/Customer/index" class="nav-item <?= strpos($currentUrl, 'admin/Customer') === 0 ? 'active' : '' ?>" title="Khách hàng">
                <i class="bi bi-people"></i> <span>Khách hàng</span>
            </a>
            <a href="index.php?url=admin/Voucher/index" class="nav-item <?= strpos($currentUrl, 'admin/Voucher') === 0 ? 'active' : '' ?>" title="Voucher">
                <i class="bi bi-ticket-perforated"></i> <span>Voucher</span>
            </a>
            <a href="index.php?url=admin/Revenue/index" class="nav-item <?= strpos($currentUrl, 'admin/Revenue') === 0 ? 'active' : '' ?>" title="Doanh thu">
                <i class="bi bi-bar-chart-line"></i> <span>Doanh thu</span>
            </a>
            <a href="index.php?url=admin/Comment/index" class="nav-item <?= strpos($currentUrl, 'admin/Comment') === 0 ? 'active' : '' ?>" title="Phản hồi">
                <i class="bi bi-chat-dots"></i> <span>Phản hồi</span>
            </a>
        </nav>
    </header>