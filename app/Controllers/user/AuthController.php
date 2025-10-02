<?php
// app/Controllers/user/AuthController.php
require_once __DIR__ . "/../../Models/User.php";

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // Form đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($identifier) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ tài khoản/mật khẩu";
                return $this->view("user/auth/login", ["error" => $error]);
            }

            $user = $this->user->findByUsernameOrEmail($identifier);

            if (!$user) {
                $error = "Sai tên đăng nhập hoặc email";
                return $this->view("user/auth/login", ["error" => $error]);
            }

            if ($user['password'] !== md5($password)) {
                $error = "Sai mật khẩu";
                return $this->view("user/auth/login", ["error" => $error]);
            }

            if ($user['account_status'] != 1) {
                $error = "Tài khoản đã bị khóa!";
                return $this->view("user/auth/login", ["error" => $error]);
            }

            // Lưu session
            $_SESSION['user'] = [
                "id" => $user['user_id'],
                "username" => $user['username'],
                "role" => $user['role']
            ];

            // Điều hướng
            if ($user['role'] == 0) { // Admin
                $this->redirect("admin/Dashboard/index");
            } else {
                $this->redirect("user/Home/index");
            }
        } else {
            $this->view("user/auth/login");
        }
    }

    // Form đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $full_name = trim($_POST['full_name'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm = trim($_POST['confirm'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            if (empty($username) || empty($password) || empty($email)) {
                $error = "Vui lòng nhập đầy đủ thông tin bắt buộc";
                return $this->view("user/auth/register", ["error" => $error]);
            }

            if ($password !== $confirm) {
                $error = "Mật khẩu xác nhận không khớp";
                return $this->view("user/auth/register", ["error" => $error]);
            }

            if ($this->user->existsByUsername($username)) {
                $error = "Tên đăng nhập đã tồn tại";
                return $this->view("user/auth/register", ["error" => $error]);
            }

            if ($this->user->existsByEmail($email)) {
                $error = "Email đã tồn tại";
                return $this->view("user/auth/register", ["error" => $error]);
            }

            $this->user->create($username, $full_name, $password, $email, $phone, $address);

            $success = "Đăng ký thành công! Vui lòng đăng nhập.";
            return $this->view("user/auth/register", ["success" => $success]);
        } else {
            $this->view("user/auth/register");
        }
    }

    // Đăng xuất
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect("user/Auth/login");
    }
}
