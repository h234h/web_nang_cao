<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1><?= $product ? "Sửa sản phẩm" : "Thêm sản phẩm" ?></h1>
    <form action="<?= Config::BASE_URL ?>index.php?url=admin/Product/save" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id_sp'] ?? '' ?>">

        <label>Tên sản phẩm</label>
        <input type="text" name="Name" value="<?= $product['Name'] ?? '' ?>" required>

        <label>Giá</label>
        <input type="number" name="Price" value="<?= $product['Price'] ?? '' ?>" required>

        <label>Hàng tồn</label>
        <input type="number" name="Mount" value="<?= $product['Mount'] ?? 0 ?>" required>

        <label>Ảnh sản phẩm</label>
        <?php if (!empty($product['image'])): ?>
            <img src="<?= Config::BASE_URL ?>public/uploads/products/<?= $product['image'] ?>" width="100"><br>
        <?php endif; ?>
        <input type="file" name="image" <?= empty($product) ? 'required' : '' ?>>

        <label>Danh mục</label>
        <select name="id_danhmuc" required>
            <option value="">Chọn danh mục</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($product['id_danhmuc'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                    <?= $cat['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Mô tả</label>
        <textarea name="Decribe"><?= $product['Decribe'] ?? '' ?></textarea>

        <label>Sale (%)</label>
        <input type="number" name="Sale" value="<?= $product['Sale'] ?? 0 ?>" min="0" max="100">

        <label>Trạng thái</label>
        <select name="status">
            <option value="1" <?= ($product['status'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
            <option value="0" <?= ($product['status'] ?? 1) == 0 ? 'selected' : '' ?>>Ẩn</option>
        </select>
        <button type="submit">Lưu</button>
        <a href="<?= Config::BASE_URL ?>index.php?url=admin/Product/index"
            style="margin-left:8px;text-decoration:none;padding:6px 12px;border:1px solid #333;border-radius:4px;background:#f0f0f0;color:#333;font-weight:600;">
            Quay lại
        </a>

    </form>

</div>