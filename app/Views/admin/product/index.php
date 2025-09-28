<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="public/assets/css/admin.css" />

<h1>Danh sách sản phẩm</h1>

<a href="index.php?url=admin/Product/form">Thêm sản phẩm</a>

<table class="product-table" border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th>Ảnh</th>
            <th>Mô tả</th>
            <th>Danh mục</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id_sp'] ?></td>

                <td class="col-name">
                    <?= htmlspecialchars($p['Name']) ?>
                </td>

                <td class="col-center"><?= number_format((float)$p['Price'], 0, ',', '.') ?></td>
                <td class="col-center"><?= (int)$p['Mount'] ?></td>

                <td class="col-img col-center">
                    <?php if (!empty($p['image'])): ?>
                        <img class="prod-thumb"
                            src="<?= Config::BASE_URL ?>public/uploads/products/<?= urlencode($p['image']) ?>"
                            alt="<?= htmlspecialchars($p['Name']) ?>">
                    <?php else: ?>
                        <span class="no-img">—</span>
                    <?php endif; ?>
                </td>

                <td class="col-desc">
                    <?php
                    $desc = trim($p['Decribe'] ?? '');
                    if ($desc !== '') echo htmlspecialchars($desc);
                    ?>
                </td>

                <td class="col-center"><?= htmlspecialchars($p['id_danhmuc'] ?? '') ?></td>
                <td class="col-center"><?= !empty($p['status']) ? 'Hiển thị' : 'Ẩn' ?></td>

                <td class="col-actions">
                    <a href="<?= Config::BASE_URL ?>index.php?url=admin/Product/form/<?= $p['id_sp'] ?>">Sửa</a>
                    <a href="<?= Config::BASE_URL ?>index.php?url=admin/Product/delete/<?= $p['id_sp'] ?>"
                        onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>