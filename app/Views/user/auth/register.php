
<h2>Đăng ký</h2>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label>Username:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Fullname:</label>
        <input type="text" name="fullname" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <button type="submit">Đăng ký</button>
</form>

<p>Đã có tài khoản? <a href="<?= Config::BASE_URL ?>index.php?url=user/auth/login">Đăng nhập</a></p>

