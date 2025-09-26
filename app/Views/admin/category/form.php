<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="public/assets/css/admin.css">
<link rel="stylesheet" href="public/assets/css/base.css">
<h1><?= isset($category) ? "Sửa" : "Thêm mới" ?> danh mục</h1>
<div id="catFormBox"
    data-existing='<?= json_encode($existingNames ?? []) ?>'
    data-current='<?= $category['name'] ?? "" ?>'>
    <div class="cat-form-card">
        <form action="<?= Config::BASE_URL ?>index.php?url=admin/Category/save" method="post">
            <input type="hidden" name="id" value="<?= $category['id'] ?? "" ?>">
            <label for="cat-name">Tên danh mục</label>
            <input type="text" id="cat-name" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
            <div id="nameErr" class="hidden" style="color:red;margin-top:4px;font-weight:600;"></div>

            <div class="cat-form-actions">
                <button type="submit" class="btn-chip btn-primary">Lưu</button>
                <a href="<?= Config::BASE_URL ?>index.php?url=admin/Category/index" class="btn-chip btn-ghost">Hủy</a>
            </div>
        </form>
    </div>
</div>

<script src="public/assets/js/admin.js"></script>