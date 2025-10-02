<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="/web_nc/public/assets/css/admin/product.css">

<h1>Sản phẩm</h1>
<a href="index.php?url=admin/Product/form">Thêm sản phẩm</a>

<table class="product-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Nghệ sĩ / Hãng</th>
            <th>Giá</th>
            <th>Tồn</th>
            <th>Ảnh</th>
            <th>Mô tả</th>
            <th>Danh mục</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($products)): ?>
            <tr>
                <td colspan="9" class="col-center">Không có sản phẩm</td>
            </tr>
            <?php else: foreach ($products as $p): ?>
                <tr>
                    <td class="col-center"><?= htmlspecialchars($p['product_id']) ?></td>
                    <td class="col-name"><?= htmlspecialchars($p['name'] ?? '') ?></td>
                    <td class="col-maker"><?= htmlspecialchars($p['maker'] ?? '') ?></td>
                    <td class="col-center">
                        <?= htmlspecialchars(number_format((float)($p['price'] ?? 0), 0, ',', '.')) ?>
                    </td>
                    <td class="col-center"><?= htmlspecialchars((string)($p['quantity'] ?? 0)) ?></td>
                    <td class="col-img col-center">
                        <?php if (!empty($p['image_url'])): ?>
                            <img class="prod-thumb" src="/web_nc/public/uploads/products/<?= htmlspecialchars($p['image_url']) ?>" alt="">
                        <?php else: ?>
                            <span class="no-img">No image</span>
                        <?php endif; ?>
                    </td>
                    <td class="col-desc"><?= htmlspecialchars($p['description'] ?? '') ?></td>

                    <!-- HIỂN THỊ TÊN DANH MỤC -->
                    <td class="col-center"><?= htmlspecialchars($p['category_name'] ?? '') ?></td>

                    <td class="col-actions">
                        <a class="btn btn-ghost" href="index.php?url=admin/Product/form/<?= urlencode($p['product_id']) ?>">Sửa</a>
                        <a class="btn btn-danger" href="index.php?url=admin/Product/delete/<?= urlencode($p['product_id']) ?>"
                            onclick="return confirm('Xoá sản phẩm này?')">Xoá</a>
                    </td>
                </tr>
        <?php endforeach;
        endif; ?>
    </tbody>
</table>