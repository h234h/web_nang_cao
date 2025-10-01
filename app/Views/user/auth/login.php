<!-- app/Views/user/auth/login.php -->
<?php if (!empty($error)): ?>
    <div style="color:red;"><?= $error ?></div>
<?php endif; ?>

<form action="index.php?url=user/auth/login" method="POST">
    <div>
        <label>Email hoặc Username:</label>
        <input type="text" name="email_or_username" required>
    </div>
    <div>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Đăng nhập</button>
</form>