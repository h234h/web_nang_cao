<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Đăng nhập - NGHE LẠI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/web_nc/public/assets/css/user/auth.css">
</head>

<body>
    <header class="auth-header">
        <div class="logo">NGHE LẠI</div>
    </header>

    <main class="auth-shell">
        <section class="auth-card">
            <nav class="auth-tabs">
                <a class="tab is-active" href="index.php?url=user/Auth/login">Đăng nhập</a>
                <a class="tab" href="index.php?url=user/Auth/signup">Đăng ký</a>
            </nav>

            <?php if (!empty($success_flash)): ?>
                <div class="flash flash-success" data-autohide="2400">
                    <?= htmlspecialchars($success_flash) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_type)): ?>
                <div class="flash <?= ($error_type === 'notfound' || $error_type === 'wrong') ? 'flash-danger' : 'flash-warn' ?>" data-autohide="2400">
                    <?= $error_type === 'notfound' ? 'Tài khoản chưa tồn tại' : 'Đã nhập sai tài khoản hoặc mật khẩu' ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?url=user/Auth/login" class="form" autocomplete="off">
                <div class="form-group">
                    <label for="identifier">Email hoặc Username</label>
                    <input
                        id="identifier"
                        name="identifier"
                        class="input"
                        type="text"
                        placeholder="Nhập email hoặc username"
                        value="<?= htmlspecialchars($old['identifier'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-wrap">
                        <input id="password" name="password" class="input" type="password" placeholder="Nhập mật khẩu" required>
                        <button class="eye" type="button" aria-label="Ẩn/hiện mật khẩu" data-eye="#password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-actions center">
                    <button class="btn btn-primary" type="submit">Đăng nhập</button>
                </div>

                <p class="forgot"><a class="forgot-link" href="index.php?url=user/Auth/forgot">Quên mật khẩu?</a></p>
            </form>
        </section>
    </main>

    <script src="/web_nc/public/assets/js/user/auth.js"></script>
</body>

</html>