<?php
// app/Core/Router.php
class Router
{
    public function run()
    {
        // Nếu không có url thì mặc định về user/Home/index
        $url = $_GET['url'] ?? "user/Home/index";
        $url = trim($url, "/");
        $parts = explode("/", $url);

        // Lấy role (user hoặc admin), mặc định là user
        $role = $parts[0] ?: "user";

        // Lấy tên controller, mặc định là Home
        $controllerName = $parts[1] ?? "Home";
        // ✅ Viết hoa chữ cái đầu để khớp với tên file (HomeController.php)
        $controllerName = ucfirst(strtolower($controllerName));

        // Lấy action, mặc định index
        $action = $parts[2] ?? "index";

        // Đường dẫn file controller
        $controllerFile = __DIR__ . "/../Controllers/{$role}/{$controllerName}Controller.php";

        if (!file_exists($controllerFile)) {
            die("Controller không tồn tại: $controllerFile");
        }
        require_once $controllerFile;

        // Tên class controller
        $className = $controllerName . "Controller";
        if (!class_exists($className)) {
            die("Class không tồn tại: $className");
        }

        $controller = new $className();

        if (!method_exists($controller, $action)) {
            die("Action không tồn tại: $action");
        }

        // Gọi action và truyền tham số nếu có
        $params = array_slice($parts, 3);
        call_user_func_array([$controller, $action], $params);
    }
}
