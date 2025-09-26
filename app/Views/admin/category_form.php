<div class="container-fluid py-3">

    <div class="mb-2 d-flex align-items-baseline flex-wrap gap-2">
        <h1 class="h4 mb-0">
            <?= htmlspecialchars($title ?? (!empty($item['id']) ? 'Sửa danh mục' : 'Thêm danh mục')) ?>
        </h1>
        <span class="text-muted small">Nhập tên danh mục và lưu lại</span>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card p-3 shadow-sm border-0 mx-auto" style="max-width: 880px;">
                <form method="post" action="/nghelai_cs/?r=admin/category/<?= !empty($item['id']) ? 'update' : 'store' ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                    <?php if (!empty($item['id'])): ?>
                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                    <?php endif; ?>

                    <?php $nameVal = htmlspecialchars($item['name'] ?? '', ENT_QUOTES);
                    $hasErr  = !empty($errors['name']); ?>

                    <div class="mb-3">
                        <label class="form-label mb-1">Tên danh mục <span class="text-danger">*</span></label>
                        <input name="name" class="form-control <?= $hasErr ? 'is-invalid' : '' ?>"
                            value="<?= $nameVal ?>" placeholder="Ví dụ: Điện thoại">
                        <?php if ($hasErr): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-center gap-2 pt-1">
                        <button class="btn btn-success text-white px-4">
                            <?= !empty($item['id']) ? 'Cập nhật' : 'Lưu' ?>
                        </button>
                        <a class="btn btn-outline-secondary px-4" href="/nghelai_cs/?r=admin/category/index">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>