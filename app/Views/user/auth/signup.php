<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Đăng ký - NGHE LẠI</title>
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
                <a class="tab" href="index.php?url=user/Auth/login">Đăng nhập</a>
                <a class="tab is-active" href="index.php?url=user/Auth/signup">Đăng ký</a>
            </nav>

            <?php if (!empty($error_type)): ?>
                <div class="flash <?= in_array($error_type, ['invalid_username', 'short_password', 'exists', 'wrong']) ? 'flash-danger' : 'flash-warn' ?>" data-autohide="2400">
                    <?php
                    switch ($error_type) {
                        case 'invalid_username':
                            echo 'Username không hợp lệ (chỉ A–Z, a–z, 0–9, gạch dưới; không dấu; không khoảng trắng)';
                            break;
                        case 'short_password':
                            echo 'Mật khẩu phải có ít nhất 6 ký tự';
                            break;
                        case 'exists':
                            echo 'Username hoặc Email đã tồn tại';
                            break;
                        default:
                            echo 'Vui lòng kiểm tra lại thông tin đăng ký';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?url=user/Auth/signup" class="form" autocomplete="off">
                <div class="form-group">
                    <label for="reg_username">Username</label>
                    <input
                        id="reg_username"
                        name="username"
                        class="input"
                        type="text"
                        placeholder="Nhập username (không dấu, không khoảng trắng)"
                        value="<?= htmlspecialchars($old['username'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="reg_email">Email</label>
                    <input
                        id="reg_email"
                        name="email"
                        class="input"
                        type="email"
                        placeholder="Nhập email của bạn"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="reg_password">Mật khẩu</label>
                    <div class="input-wrap">
                        <input id="reg_password" name="password" class="input" type="password" placeholder="Tối thiểu 6 ký tự" required>
                        <button class="eye" type="button" data-eye="#reg_password" aria-label="Ẩn/hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reg_confirm">Xác nhận mật khẩu</label>
                    <div class="input-wrap">
                        <input id="reg_confirm" name="confirm" class="input" type="password" placeholder="Nhập lại mật khẩu" required>
                        <button class="eye" type="button" data-eye="#reg_confirm" aria-label="Ẩn/hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-actions center">
                    <button class="btn btn-primary" type="submit">Đăng ký</button>
                </div>
            </form>
        </section>
    </main>

    <script src="/web_nc/public/assets/js/user/auth.js"></script>
</body>

</html>