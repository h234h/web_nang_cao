<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>

<div class="container">
    <?php if ($product): ?>
        <h1><?php echo htmlspecialchars($product['Name']); ?></h1>
        <img src="public/uploads/products/<?php echo $product['image']; ?>"
            alt="<?php echo htmlspecialchars($product['Name']); ?>"
            style="width: 300px; height: auto; border-radius: 5px;">

        <p><?php echo nl2br(htmlspecialchars($product['Decribe'])); ?></p>
        <p><strong>Giá: <?php echo number_format($product['Price']); ?> đ</strong></p>
        <p>Tồn kho: <?php echo (int)$product['Mount']; ?></p>
        <?php if ($product['Sale'] > 0): ?>
            <p>Giảm giá: <?php echo $product['Sale']; ?>%</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Sản phẩm không tồn tại!</p>
    <?php endif; ?>
</div>