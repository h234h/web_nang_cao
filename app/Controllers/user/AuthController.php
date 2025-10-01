<?php
// app/Controllers/user/AuthController.php
require_once __DIR__ . '/../../Core/BaseController.php';
require_once __DIR__ . '/../../Models/User.php';

class AuthController extends BaseController
{
    private function redirectByRole($role)
    {
        // Router của bạn dùng tham số "url", nên truyền path, KHÔNG dùng ?r=
        if ((int)$role === 0) {
            $this->redirect('admin/Dashboard/index'); // admin → dashboard
        } else {
            $this->redirect('user/Home/index');       // user → home
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = (string)($_POST['password'] ?? '');

            $userModel = new User();
            $user = $userModel->verifyLogin($username, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['auth'] = [
                    'id_user'  => $user['id_user'],
                    'username' => $user['username'],
                    'role'     => (int)$user['role'],
                    'fullname' => $user['fullname'] ?? '',
                    'email'    => $user['email'] ?? '',
                ];
                $this->redirectByRole((int)$user['role']);
                return;
            }

            $data = ['error' => 'Sai tên đăng nhập hoặc mật khẩu.'];
            return $this->view('user/auth/login', $data);   // dùng view()
        }

        // GET
        return $this->view('user/auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = (string)($_POST['password'] ?? '');
            $repass   = (string)($_POST['repass'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $phone    = trim($_POST['phone'] ?? '');
            $address  = trim($_POST['address'] ?? '');

            $errors = [];
            if ($username === '' || $password === '' || $fullname === '' || $email === '') {
                $errors[] = 'Vui lòng điền đủ các trường bắt buộc.';
            }
            if ($password !== $repass) {
                $errors[] = 'Mật khẩu nhập lại không khớp.';
            }

            $userModel = new User();
            if ($userModel->findByUsername($username)) {
                $errors[] = 'Tên đăng nhập đã tồn tại.';
            }
            if ($userModel->findByEmail($email)) {
                $errors[] = 'Email đã tồn tại.';
            }

            if (!empty($errors)) {
                return $this->view('user/auth/register', ['errors' => $errors, 'old' => $_POST]);
            }

            $ok = $userModel->create([
                'username' => $username,
                'password' => $password,
                'fullname' => $fullname,
                'email'    => $email,
                'phone'    => $phone,
                'address'  => $address,
            ]);

            if ($ok) {
                // auto login sau đăng ký
                $user = $userModel->verifyLogin($username, $password);
                if ($user) {
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['auth'] = [
                        'id_user'  => $user['id_user'],
                        'username' => $user['username'],
                        'role'     => (int)$user['role'],
                        'fullname' => $user['fullname'] ?? '',
                        'email'    => $user['email'] ?? '',
                    ];
                    $this->redirectByRole((int)$user['role']);
                    return;
                }
                // fallback
                $this->redirect('user/Auth/login');
                return;
            }

            return $this->view('user/auth/register', [
                'errors' => ['Không thể tạo tài khoản. Vui lòng thử lại.'],
                'old'    => $_POST
            ]);
        }

        // GET
        return $this->view('user/auth/register');
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['auth']);
        session_destroy();
        $this->redirect('user/Auth/login');
    }
}
