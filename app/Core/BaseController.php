<?php
// app/Core/BaseController.php
class BaseController
{
    protected function view($path, $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../Views/" . $path . ".php";
    }

    protected function redirect($url)
    {
        // Dùng BASE_URL đã cấu hình
        header("Location: " . Config::BASE_URL . "index.php?url=" . $url);
        exit();
    }
}
