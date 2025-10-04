<?php
// app/Controllers/user/AuthController.php
require_once __DIR__ . "/../../Models/User.php";
require_once __DIR__ . "/../../Core/BaseController.php";

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** GET/POST: index.php?url=user/Auth/login */
    public function login()
    {
        $error_type = "";
        $old = [];

        // Lấy flash nếu có (đăng ký thành công)
        $success_flash = $_SESSION['flash_success'] ?? "";
        if (!empty($success_flash)) {
            unset($_SESSION['flash_success']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = trim($_POST['identifier'] ?? '');
            $password   = trim($_POST['password'] ?? '');
            $old['identifier'] = $identifier; // để giữ lại khi lỗi

            if ($identifier === '' || $password === '') {
                $error_type = 'wrong';
            } else {
                $u = $this->user->getByIdentifier($identifier);
                if (!$u) {
                    $error_type = 'notfound';
                } else {
                    // Hỗ trợ MD5 (32 ký tự) hoặc bcrypt
                    $ok = (strlen($u['password']) === 32)
                        ? (md5($password) === strtolower($u['password']))
                        : password_verify($password, $u['password']);

                    if ($ok) {
                        $_SESSION['user'] = $u;
                        $dest = ((int)$u['role'] === 0)
                            ? "admin/Dashboard/index"
                            : "user/Home/index";
                        $this->redirect($dest);
                        return;
                    }
                    $error_type = 'wrong';
                }
            }
        }

        $this->view("user/auth/login", [
            "error_type"    => $error_type,
            "success_flash" => $success_flash,
            "old"           => $old,
        ]);
    }

    /** Public alias cho URL /signup */
    public function signup()
    {
        return $this->register();
    }

    /** GET/POST: index.php?url=user/Auth/signup */
    private function register()
    {
        $error_type = "";
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm  = trim($_POST['confirm'] ?? '');

            // Lưu để đổ lại nếu lỗi
            $old['username'] = $username;
            $old['email']    = $email;

            // Username: chỉ A-Z a-z 0-9 _ ; không dấu & không khoảng trắng
            $validUser = $username !== '' &&
                !preg_match('/\s/', $username) &&
                preg_match('/^[A-Za-z0-9_]+$/', $username);

            if (!$validUser) {
                $error_type = 'invalid_username';
            } elseif ($password === '' || $confirm === '' || $email === '') {
                $error_type = 'wrong';
            } elseif (mb_strlen($password) < 6) {
                $error_type = 'short_password';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_type = 'wrong';
            } elseif ($password !== $confirm) {
                $error_type = 'wrong';
            } elseif ($this->user->existsUsername($username) || $this->user->existsEmail($email)) {
                $error_type = 'exists';
            } else {
                $hash = md5($password); // theo schema hiện tại
                $ok = $this->user->create([
                    "username"  => $username,
                    "full_name" => null,
                    "password"  => $hash,
                    "email"     => $email,
                    "role"      => 1, // user
                ]);
                if ($ok) {
                    // Đặt flash & về login (không dùng query string)
                    $_SESSION['flash_success'] = 'Đăng ký thành công, vui lòng đăng nhập để vào web';
                    $this->redirect("user/Auth/login");
                    return;
                }
                $error_type = 'wrong';
            }
        }

        $this->view("user/auth/signup", [
            "error_type" => $error_type,
            "old"        => $old
        ]);
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Hủy session user
        unset($_SESSION['user']);
        unset($_SESSION['cart_count']);
        session_destroy();

        // Redirect về home thay vì login
        header("Location: index.php?url=user/home");
        exit;
    }
}
