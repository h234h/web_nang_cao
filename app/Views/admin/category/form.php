<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1><?= isset($category) ? "Cập nhật" : "Thêm mới" ?> danh mục</h1>

<form action="<?= Config::BASE_URL ?>index.php?url=admin/Category/save" method="POST">
    <?php if (isset($category)): ?>
        <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <?php endif; ?>
    <label>Tên danh mục:</label><br>
    <input type="text" name="name" value="<?= $category['name'] ?? '' ?>" required><br><br>
    <button type="submit">Lưu</button>
</form>

<a href="<?= Config::BASE_URL ?>index.php?url=admin/Category/index">Quay lại</a>