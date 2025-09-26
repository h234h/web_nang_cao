<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1>Danh mục sản phẩm</h1>
<a href="<?= Config::BASE_URL ?>index.php?url=admin/Category/form">Thêm mới</a>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Ngày tạo</th>
            <th>Ngày cập nhật</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['name']) ?></td>
                <td><?= $cat['created_at'] ?></td>
                <td><?= $cat['updated_at'] ?></td>
                <td>
                    <a href="<?= Config::BASE_URL ?>index.php?url=admin/Category/form/<?= $cat['id'] ?>">Sửa</a> |
                    <a href="<?= Config::BASE_URL ?>index.php?url=admin/Category/delete/<?= $cat['id'] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>