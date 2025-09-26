<?php
// $title, $categories, $item, $errors
$csrf_token = $csrf_token ?? ($csrf_token = $this->csrfToken());
$isEdit     = !empty($item['id_sp']);
$action     = $isEdit ? 'update' : 'store';

$Name       = htmlspecialchars($item['Name']       ?? '', ENT_QUOTES);
$Price      = htmlspecialchars((string)($item['Price'] ?? ''), ENT_QUOTES);
$Decribe    = htmlspecialchars($item['Decribe']    ?? '', ENT_QUOTES);
$Mount      = (int)($item['Mount']      ?? 0);
$Sale       = (int)($item['Sale']       ?? 0);
$id_dm      = (int)($item['id_danhmuc'] ?? 0);
$status     = (int)($item['status']     ?? 1);

$has = fn($k) => !empty($errors[$k]);
$err = fn($k) => htmlspecialchars($errors[$k] ?? '');
?>
<link rel="stylesheet" href="/nghelai_cs/public/admin/css/product.css">

<div class="container-fluid py-3 page-product">
    <div class="mb-2 d-flex align-items-baseline flex-wrap gap-2">
        <h1 class="h4 mb-0"><?= htmlspecialchars($title ?? ($isEdit ? 'Sửa sản phẩm' : 'Thêm sản phẩm')) ?></h1>
        <span class="text-muted small">Nhập thông tin và lưu lại</span>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card p-3 shadow-sm border-0 mx-auto card-form">
                <form method="post" enctype="multipart/form-data" action="/nghelai_cs/?r=admin/product/<?= $action ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id_sp" value="<?= (int)$item['id_sp'] ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label mb-1">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input name="Name" class="form-control <?= $has('Name') ? 'is-invalid' : '' ?>" value="<?= $Name ?>" placeholder="Ví dụ: iPhone 15">
                            <?php if ($has('Name')): ?><div class="invalid-feedback"><?= $err('Name') ?></div><?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-1">Danh mục <span class="text-danger">*</span></label>
                            <select name="id_danhmuc" class="form-select <?= $has('id_danhmuc') ? 'is-invalid' : '' ?>">
                                <option value="0">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $c): ?>
                                    <option value="<?= (int)$c['id'] ?>" <?= $id_dm === (int)$c['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($has('id_danhmuc')): ?><div class="invalid-feedback"><?= $err('id_danhmuc') ?></div><?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-1">Giá (đ) <span class="text-danger">*</span></label>
                            <input name="Price" type="number" min="1" step="1" class="form-control <?= $has('Price') ? 'is-invalid' : '' ?>" value="<?= $Price ?>" placeholder="1.000.000">
                            <?php if ($has('Price')): ?><div class="invalid-feedback"><?= $err('Price') ?></div><?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-1">Giảm giá (%)</label>
                            <input name="Sale" type="number" min="0" max="100" class="form-control <?= $has('Sale') ? 'is-invalid' : '' ?>" value="<?= $Sale ?>" placeholder="0..100">
                            <?php if ($has('Sale')): ?><div class="invalid-feedback"><?= $err('Sale') ?></div><?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-1">Tồn kho <span class="text-danger">*</span></label>
                            <input name="Mount" type="number" min="1" step="1" class="form-control <?= $has('Mount') ? 'is-invalid' : '' ?>" value="<?= $Mount ?>" placeholder="1">
                            <?php if ($has('Mount')): ?><div class="invalid-feedback"><?= $err('Mount') ?></div><?php endif; ?>
                        </div>

                        <div class="col-12">
                            <label class="form-label mb-1">Mô tả</label>
                            <textarea name="Decribe" class="form-control" rows="4" placeholder="Mô tả ngắn..."><?= $Decribe ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mb-1">Ảnh chính <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
                            <input id="inputMainImage" type="file" name="image" accept="image/*" class="form-control <?= $has('image') ? 'is-invalid' : '' ?>">
                            <?php if ($has('image')): ?><div class="invalid-feedback"><?= $err('image') ?></div><?php endif; ?>

                            <div id="previewMain" class="preview-wrap mt-2">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="/nghelai_cs/public<?= htmlspecialchars($item['image']) ?>" class="img-main" alt="">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label mb-1">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1" <?= $status === 1 ? 'selected' : '' ?>>Kích hoạt</option>
                                <option value="0" <?= $status === 0 ? 'selected' : '' ?>>Tắt</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 pt-3">
                        <button class="btn btn-success text-white px-4"><?= $isEdit ? 'Cập nhật' : 'Lưu' ?></button>
                        <a class="btn btn-outline-secondary px-4" href="/nghelai_cs/?r=admin/product/index">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/nghelai_cs/public/admin/js/product-form.js"></script>