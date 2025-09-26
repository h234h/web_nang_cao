<link rel="stylesheet" href="/nghelai_cs/public/assets/css/base.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<nav class="admin-header">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center justify-content-between px-3 py-2">

        <!-- Left: Avatar + Admin + Bell -->
        <div class="d-flex align-items-center gap-2">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                alt="avatar" class="avatar">
            <span class="user-name">Admin</span>
            <button id="btnBell" type="button" class="icon-btn ms-2" title="Thông báo">
                <i class="bi bi-bell"></i>
            </button>
        </div>

        <!-- Middle: Search -->
        <form class="search-form flex-grow-1 mx-3" method="get">
            <input type="hidden" name="r" value="<?= htmlspecialchars($_GET['r'] ?? '') ?>">
            <input type="search" class="form-control form-control-sm text-center"
                placeholder="Tìm kiếm...">
        </form>

        <!-- Right: Logo + brand -->
        <div class="d-flex align-items-center">
            <div class="logo">TS</div>
            <div class="brand-name ms-2">Nghe Lai</div>
        </div>
    </div>

    <!-- Menu -->
    <div class="topnav d-flex justify-content-center flex-wrap gap-2 py-2">
        <button class="menu-btn active"><i class="bi bi-speedometer2 me-1"></i> Dashboard</button>
        <button class="menu-btn"><i class="bi bi-box-seam me-1"></i> Sản phẩm</button>
        <button class="menu-btn"><i class="bi bi-bar-chart-line me-1"></i> Doanh thu</button>
        <button class="menu-btn"><i class="bi bi-tags me-1"></i> Danh mục</button>
        <button class="menu-btn"><i class="bi bi-receipt me-1"></i> Đơn hàng</button>
        <button class="menu-btn"><i class="bi bi-people me-1"></i> Nhân viên</button>
        <button class="menu-btn"><i class="bi bi-person-badge me-1"></i> Khách hàng</button>
        <button class="menu-btn"><i class="bi bi-chat-dots me-1"></i> Feedback</button>
        <button class="menu-btn"><i class="bi bi-ticket-perforated me-1"></i> Voucher</button>
    </div>
</nav>