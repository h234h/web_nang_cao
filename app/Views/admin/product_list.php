<?php
// $title, $items, $page, $pages, $total, $q đã được truyền
?>
<div class="container-fluid py-3 page-product">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-0"><?= htmlspecialchars($title ?? 'Quản lý sản phẩm') ?></h1>
            <div class="text-muted small">Tổng: <?= (int)$total ?> sản phẩm</div>
        </div>
        <div class="d-flex gap-2">

            <a class="btn btn-success text-white" href="/nghelai_cs/?r=admin/product/create">+ Thêm sản phẩm</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle product-table mb-0">
                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Tên sản phẩm</th>
                        <th style="width:140px">Giá (đ)</th>
                        <th style="width:100px">Số lượng</th>
                        <th style="width:120px">Trạng thái</th>
                        <th>Danh mục</th>
                        <th style="width:90px">Ảnh</th>
                        <th style="width:140px" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Chưa có sản phẩm.</td>
                        </tr>
                        <?php else: foreach ($items as $i => $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id_sp']) ?></td>
                                <td><?= htmlspecialchars($row['Name']) ?></td>
                                <td><?= number_format((float)$row['Price'], 0, ',', '.') ?></td>
                                <td><?= (int)$row['Mount'] ?></td>
                                <td>
                                    <?php if ((int)$row['status'] === 1): ?>
                                        <span class="badge bg-success">Kích hoạt</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tắt</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['category_name'] ?? '') ?></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="/nghelai_cs/public<?= htmlspecialchars($row['image']) ?>" class="img-thumb" alt="">
                                    <?php else: ?>
                                        <span class="thumb-empty">No</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-light" href="/nghelai_cs/?r=admin/product/edit&id=<?= (int)$row['id_sp'] ?>">Sửa</a>
                                    <form class="d-inline" method="post" action="/nghelai_cs/?r=admin/product/delete" onsubmit="return confirm('Xoá sản phẩm này?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                        <input type="hidden" name="id" value="<?= (int)$row['id_sp'] ?>">
                                        <button class="btn btn-sm btn-danger">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (($pages ?? 1) > 1): ?>
        <nav class="mt-3">
            <ul class="pagination pagination-sm">
                <?php for ($p = 1; $p <= $pages; $p++): ?>
                    <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                        <a class="page-link" href="/nghelai_cs/?r=admin/product/index&page=<?= $p ?>&q=<?= urlencode($q ?? '') ?>"><?= $p ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>