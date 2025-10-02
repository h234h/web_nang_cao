<?php
class HomeController extends BaseController
{
    public function index()
    {
        // Nếu chưa login thì chuyển về trang login
        if (!isset($_SESSION['user'])) {
            $this->redirect("user/Auth/login");
        }

        $this->view("user/home", [
            "user" => $_SESSION['user']
        ]);
    }
}
