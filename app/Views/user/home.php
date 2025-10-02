<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ - User</title>
</head>

<body>
    <h1>Xin chào, <?php echo htmlspecialchars($user['username']); ?> 👋</h1>
    <p>Đây là trang Home của User.</p>

    <p><a href="index.php?url=user/Auth/logout">Đăng xuất</a></p>
</body>

</html>