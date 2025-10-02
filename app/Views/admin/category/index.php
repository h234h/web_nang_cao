<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="public/assets/css/admin/category.css" />

<h1>Danh mục sản phẩm</h1>
<a href="index.php?url=admin/Category/form">Thêm mới</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($categories)): ?>
            <tr>
                <td colspan="3" style="text-align:center">Không có danh mục</td>
            </tr>
            <?php else: foreach ($categories as $cat): ?>
                <tr>
                    <td style="text-align:center"><?= htmlspecialchars($cat['category_id']) ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td>
                        <a href="index.php?url=admin/Category/form/<?= urlencode($cat['category_id']) ?>">Sửa</a> |
                        <a href="index.php?url=admin/Category/delete/<?= urlencode($cat['category_id']) ?>"
                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
        <?php endforeach;
        endif; ?>
    </tbody>
</table>