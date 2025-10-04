<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="/web_nc/public/assets/css/admin/category.css">

<?php
$catId   = $old['id']                ?? ($category['category_id']   ?? '');
$catName = $old['name']              ?? ($category['category_name'] ?? '');
$title   = $catId ? "Sửa danh mục" : "Thêm danh mục";
?>

<h1><?= htmlspecialchars($title) ?></h1>

<?php if (!empty($error)): ?>
    <div><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="index.php?url=admin/Category/save" class="cat-form-card">
    <input type="hidden" name="id" value="<?= htmlspecialchars($catId) ?>">

    <label for="name">Tên danh mục</label>
    <input id="name" name="name" type="text" required value="<?= htmlspecialchars($catName) ?>">

    <div class="cat-form-actions">
        <button type="submit" class="btn-chip btn-primary">Lưu</button>
        <a href="index.php?url=admin/Category/index" class="btn-chip btn-ghost">Hủy</a>
    </div>
</form>