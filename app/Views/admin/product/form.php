<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="/web_nc/public/assets/css/admin/product.css">

<?php
$prod  = $product ?? [];
$old   = $old ?? [];
$id    = $old['id']         ?? ($prod['product_id']   ?? '');
$name  = $old['Name']       ?? ($prod['name']         ?? '');
$maker = $old['maker']      ?? ($prod['maker']        ?? '');
$price = $old['Price']      ?? ($prod['price']        ?? '');
$desc  = $old['Decribe']    ?? ($prod['description']  ?? '');
$qty   = $old['Mount']      ?? ($prod['quantity']     ?? '');
$sale  = $old['Sale']       ?? ($prod['sale_percent'] ?? '');
$cid   = $old['id_danhmuc'] ?? ($prod['category_id']  ?? '');
$img   = $old['image']      ?? ($prod['image_url']    ?? '');
$title = $id ? "Sửa sản phẩm" : "Thêm sản phẩm";
?>

<h1><?= htmlspecialchars($title) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="toast" id="toast">
        <?php foreach ($errors as $msg): ?>
            <div><?= htmlspecialchars($msg) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="prod-form-wrap">
    <form class="prod-form" method="post" action="index.php?url=admin/Product/save" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <label for="Name">Tên sản phẩm</label>
        <input id="Name" name="Name" type="text" required placeholder="Nhập tên sản phẩm"
            value="<?= htmlspecialchars($name) ?>">

        <label for="maker">Nghệ sĩ / Hãng</label>
        <input id="maker" name="maker" type="text" placeholder="VD: Taylor Swift / Universal"
            value="<?= htmlspecialchars($maker) ?>">

        <label for="Price">Giá</label>
        <input id="Price" name="Price" type="number" step="0.01" min="0" required placeholder="VD: 199000"
            value="<?= htmlspecialchars($price) ?>">

        <label for="Mount">Số lượng</label>
        <input id="Mount" name="Mount" type="number" min="0" required placeholder="VD: 10"
            value="<?= htmlspecialchars($qty) ?>">

        <label for="Sale">Giảm (%)</label>
        <input id="Sale" name="Sale" type="number" min="0" max="100" placeholder="0 - 100"
            value="<?= htmlspecialchars($sale) ?>">

        <label for="id_danhmuc">Danh mục</label>
        <select id="id_danhmuc" name="id_danhmuc" required>
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= htmlspecialchars($c['category_id']) ?>"
                    <?= (string)$cid === (string)$c['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="image">Ảnh</label>
        <input id="image" name="image" type="file" accept="image/*">

        <?php if (!empty($img)): ?>
            <label>Ảnh hiện tại</label>
            <!-- class này khớp CSS để hiển thị nhỏ & căn giữa -->
            <img class="prod-thumb-inline" src="/web_nc/public/uploads/products/<?= htmlspecialchars($img) ?>" alt="">
        <?php endif; ?>

        <label for="Decribe">Mô tả</label>
        <textarea id="Decribe" name="Decribe" placeholder="Mô tả ngắn gọn về sản phẩm"><?= htmlspecialchars($desc) ?></textarea>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a class="btn btn-ghost" href="index.php?url=admin/Product/index">Hủy</a>
        </div>
    </form>
</div>