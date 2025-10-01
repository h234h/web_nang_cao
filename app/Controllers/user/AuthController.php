<?php
// app/Controllers/user/AuthController.php
require_once __DIR__ . "/../../Models/User.php";
require_once __DIR__ . "/../../Core/BaseController.php";

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // ⚡ bắt buộc start session
        }
    }

    // 🔑 Login chung cho admin và user
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emailOrUsername = trim($_POST['email_or_username'] ?? '');
            $password        = trim($_POST['password'] ?? '');

            $user = $this->userModel->login($emailOrUsername, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                // Nếu admin (role = 0) → dashboard
                if ($user['role'] == 0) {
                    $this->redirect("admin/dashboard/index");
                }
                // Nếu user (role = 1) → home
                else {
                    $this->redirect("user/home/index");
                }
            } else {
                $error = "Email/Username hoặc mật khẩu không đúng!";
                $this->view("user/auth/login", ['error' => $error]);
            }
        } else {
            $this->view("user/auth/login");
        }
    }

    // 🔓 Logout
    public function logout()
    {
        session_destroy();
        $this->redirect("user/auth/login");
    }
}
