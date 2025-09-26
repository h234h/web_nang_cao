<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0">Quản lý danh mục</h1>
            <div class="text-muted small">Tạo và sắp xếp các nhóm sản phẩm của bạn</div>
        </div>

        <a href="/nghelai_cs/?r=admin/category/create" class="btn btn-success text-white">
            <i class="bi bi-plus-lg me-1"></i> Thêm danh mục
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:80px">#</th>
                        <th>Tên danh mục</th>
                        <th style="width:200px">Cập nhật</th>
                        <th style="width:170px" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): foreach ($items as $row): ?>
                            <tr>
                                <td class="fw-semibold"><?= (int)$row['id'] ?></td>
                                <td><i class="bi bi-folder2-open me-2"></i><?= htmlspecialchars($row['name']) ?></td>
                                <td><i class="bi bi-clock me-1"></i><?= htmlspecialchars($row['updated_at']) ?></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a class="btn btn-outline-secondary" href="/nghelai_cs/?r=admin/category/edit&id=<?= (int)$row['id'] ?>">
                                            <i class="bi bi-pencil-square me-1"></i>Sửa
                                        </a>
                                        <a class="btn btn-outline-secondary"
                                            href="/nghelai_cs/?r=admin/category/delete&id=<?= (int)$row['id'] ?>"
                                            onclick="return confirm('Xóa danh mục này?');">
                                            <i class="bi bi-trash3 me-1"></i>Xóa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="4" class="py-5">
                                <div class="text-center">
                                    <div class="mb-2" style="font-size:32px;"><i class="bi bi-folder-x"></i></div>
                                    <div class="fw-semibold mb-1">Chưa có danh mục nào</div>
                                    <div class="text-muted mb-3">Hãy tạo danh mục đầu tiên để tổ chức sản phẩm.</div>
                                    <a href="/nghelai_cs/?r=admin/category/create" class="btn btn-success text-white btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i> Thêm danh mục
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>