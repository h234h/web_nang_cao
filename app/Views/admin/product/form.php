<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $product ? "Sửa sản phẩm" : "Thêm sản phẩm" ?></h1>

<div class="prod-form-wrap">
    <form class="prod-form"
        action="<?= Config::BASE_URL ?>index.php?url=admin/Product/save"
        method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id_sp'] ?? '' ?>">

        <label for="name">Tên sản phẩm</label>
        <input id="name" type="text" name="Name" value="<?= $product['Name'] ?? '' ?>" required>

        <label for="price">Giá</label>
        <input id="price" type="number" name="Price" value="<?= $product['Price'] ?? '' ?>" required>

        <label for="mount">Hàng tồn</label>
        <input id="mount" type="number" name="Mount" value="<?= $product['Mount'] ?? 0 ?>" required>

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

        <label for="cat">Danh mục</label>
        <select id="cat" name="id_danhmuc" required>
            <option value="">Chọn danh mục</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= ($product['id_danhmuc'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="desc">Mô tả</label>
        <textarea id="desc" name="Decribe"><?= $product['Decribe'] ?? '' ?></textarea>

        <label for="sale">Sale (%)</label>
        <input id="sale" type="number" name="Sale" value="<?= $product['Sale'] ?? 0 ?>" min="0" max="100">

        <label for="status">Trạng thái</label>
        <select id="status" name="status">
            <option value="1" <?= ($product['status'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
            <option value="0" <?= ($product['status'] ?? 1) == 0 ? 'selected' : '' ?>>Ẩn</option>
        </select>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a class="btn btn-ghost" href="<?= Config::BASE_URL ?>index.php?url=admin/Product/index">Quay lại</a>
        </div>
    </form>
</div>