<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nghe Lại Shop</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            /* Để footer sticky */
            display: flex;
            flex-direction: column;
        }

        header {
            background: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 20px;
            font-weight: bold;
        }

        header .right a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        main {
            flex: 1;
            /* chiếm khoảng trống để footer xuống dưới */
            padding: 20px;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">🎵 Nghe Lại Shop</div>
        <div class="right">
            <a href="#">Giỏ hàng 🛒</a>
            <a href="#">Đăng nhập</a>
            <a href="#">Đăng ký</a>
        </div>
    </header>
    <main>