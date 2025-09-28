<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/assets/css/admin/product.css" />

<h1><?= $product ? "Sửa sản phẩm" : "Thêm sản phẩm" ?></h1>

<div class="prod-form-wrap">
    <form class="prod-form"
        action="<?= Config::BASE_URL ?>index.php?url=admin/Product/save"
        method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $product['id_sp'] ?? '' ?>">

        <!-- Tên sản phẩm -->
        <label for="name">Tên sản phẩm</label>
        <input id="name" type="text" name="Name"
            value="<?= htmlspecialchars($old['Name'] ?? $product['Name'] ?? '') ?>" required>
        <?php if (!empty($errors['Name'])): ?>
            <div class="error"><?= htmlspecialchars($errors['Name']) ?></div>
        <?php endif; ?>

        <!-- Giá -->
        <label for="price">Giá</label>
        <input id="price" type="number" name="Price"
            value="<?= htmlspecialchars($old['Price'] ?? $product['Price'] ?? '') ?>" required>
        <?php if (!empty($errors['Price'])): ?>
            <div class="error"><?= htmlspecialchars($errors['Price']) ?></div>
        <?php endif; ?>

        <!-- Hàng tồn -->
        <label for="mount">Hàng tồn</label>
        <input id="mount" type="number" name="Mount"
            value="<?= htmlspecialchars($old['Mount'] ?? $product['Mount'] ?? 0) ?>" required>
        <?php if (!empty($errors['Mount'])): ?>
            <div class="error"><?= htmlspecialchars($errors['Mount']) ?></div>
        <?php endif; ?>

        <!-- Ảnh -->
        <label>Ảnh sản phẩm</label>
        <?php if (!empty($product['image'])): ?>
            <img class="prod-thumb-inline"
                src="<?= Config::BASE_URL ?>public/uploads/products/<?= htmlspecialchars($product['image']) ?>"
                alt="Ảnh hiện tại">
        <?php else: ?>
            <span style="opacity:.7">Chưa có ảnh</span>
        <?php endif; ?>

        <label for="image">Chọn ảnh mới</label>
        <input id="image" type="file" name="image" <?= empty($product) ? 'required' : '' ?>>
        <?php if (!empty($errors['image'])): ?>
            <div class="error"><?= htmlspecialchars($errors['image']) ?></div>
        <?php endif; ?>

        <!-- Danh mục -->
        <label for="cat">Danh mục</label>
        <select id="cat" name="id_danhmuc" required>
            <option value="">Chọn danh mục</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= ($old['id_danhmuc'] ?? $product['id_danhmuc'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Mô tả -->
        <label for="desc">Mô tả</label>
        <textarea id="desc" name="Decribe"><?= htmlspecialchars($old['Decribe'] ?? $product['Decribe'] ?? '') ?></textarea>

        <!-- Sale -->
        <label for="sale">Sale (%)</label>
        <input id="sale" type="number" name="Sale"
            value="<?= htmlspecialchars($old['Sale'] ?? $product['Sale'] ?? 0) ?>"
            min="0" max="100">

        <!-- Trạng thái -->
        <label for="status">Trạng thái</label>
        <select id="status" name="status">
            <option value="1" <?= ($old['status'] ?? $product['status'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
            <option value="0" <?= ($old['status'] ?? $product['status'] ?? 1) == 0 ? 'selected' : '' ?>>Ẩn</option>
        </select>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a class="btn btn-ghost" href="index.php?url=admin/Product/index">Quay lại</a>
        </div>
    </form>
</div>

<?php if (!empty($errors)): ?>
    <script>
        // Ẩn div.error sau 3 giây
        setTimeout(() => {
            document.querySelectorAll('.error').forEach(el => {
                el.style.display = 'none';
            });
        }, 3000);

        // Toast cảnh báo
        (function() {
            const t = document.createElement('div');
            t.className = 'toast warning';
            t.textContent = "<?= addslashes(reset($errors)) ?>";
            document.body.appendChild(t);
            setTimeout(() => t.classList.add('hide'), 2500);
            setTimeout(() => t.remove(), 2800);
        })();
    </script>
<?php endif; ?>