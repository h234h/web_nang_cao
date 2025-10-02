<!-- app/Views/user/auth/register.php -->
<div class="container" style="max-width:720px;margin:40px auto;">
    <h2 class="mb-3">Đăng ký</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul style="margin:0;padding-left:18px;">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?url=user/Auth/register">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tên đăng nhập *</label>
                <input type="text" name="username" class="form-control" required
                    value="<?= htmlspecialchars($old['username'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Họ tên *</label>
                <input type="text" name="fullname" class="form-control" required
                    value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" required
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control"
                    value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control"
                    value="<?= htmlspecialchars($old['address'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Mật khẩu *</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nhập lại mật khẩu *</label>
                <input type="password" name="repass" class="form-control" required>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
            <a class="btn btn-outline-secondary" href="index.php?url=user/Auth/login">Đã có tài khoản</a>
        </div>
    </form>
</div>