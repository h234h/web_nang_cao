<!-- app/Views/user/auth/login.php -->
<div class="container" style="max-width:520px;margin:40px auto;">
    <h2 class="mb-3">Đăng nhập</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?url=user/Auth/login">
        <div class="mb-3">
            <label class="form-label">Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
            <a class="btn btn-outline-secondary" href="index.php?url=user/Auth/register">Đăng ký</a>
        </div>
    </form>
</div>