<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1>Danh sách sản phẩm</h1>

<a href="<?= Config::BASE_URL ?>index.php?url=admin/Product/form">Thêm sản phẩm</a>
<table border="1" cellpadding="8" cellspacing="0"
    style="table-layout:fixed;width:100%;border-collapse:collapse;">
    <colgroup>
        <col style="width:56px"> <!-- ID -->
        <col> <!-- Tên -->
        <col style="width:110px"> <!-- Giá -->
        <col style="width:90px"> <!-- Tồn kho -->
        <col style="width:72px"> <!-- Ảnh -->
        <col> <!-- Mô tả -->
        <col style="width:120px"> <!-- Danh mục -->
        <col style="width:96px"> <!-- Trạng thái -->
        <col style="width:110px"> <!-- Thao tác -->
    </colgroup>
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
                <td style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= htmlspecialchars($p['Name']) ?>
                </td>
                <td><?= number_format((float)$p['Price'], 0, ',', '.') ?></td>
                <td><?= (int)$p['Mount'] ?></td>

                <!-- ẢNH THUMB 44x44 CỐ ĐỊNH -->
                <td style="text-align:center;vertical-align:middle;">
                    <?php if (!empty($p['image'])): ?>
                        <img
                            src="<?= Config::BASE_URL ?>public/uploads/products/<?= urlencode($p['image']) ?>"
                            alt="<?= htmlspecialchars($p['Name']) ?>"
                            width="44" height="44"
                            style="object-fit:cover;border-radius:8px;display:inline-block;border:1px solid #333;background:#0f0f0f">
                    <?php else: ?>
                        <span style="opacity:.6;font-weight:700;">—</span>
                    <?php endif; ?>
                </td>

                <!-- MÔ TẢ: cắt ngắn bằng PHP, không CSS -->
                <td style="overflow:hidden;">
                    <?php
                    $desc = trim($p['Decribe'] ?? '');
                    if ($desc !== '') {
                        // cắt còn ~150 ký tự, thêm dấu …
                        echo htmlspecialchars(mb_strimwidth($desc, 0, 150, '…', 'UTF-8'));
                    }
                    ?>
                </td>

                <!-- Nếu đã JOIN tên danh mục thì đổi id_danhmuc -> category_name -->
                <td><?= htmlspecialchars($p['id_danhmuc'] ?? '') ?></td>
                <td><?= !empty($p['status']) ? 'Hiển thị' : 'Ẩn' ?></td>

                <td>
                    <a href="<?= Config::BASE_URL ?>index.php?url=admin/Product/form/<?= $p['id_sp'] ?>">Sửa</a> |
                    <a href="<?= Config::BASE_URL ?>index.php?url=admin/Product/delete/<?= $p['id_sp'] ?>"
                        onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>