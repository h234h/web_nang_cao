<?php
// app/Core/Router.php
class Router
{
    public function run()
    {
        $url = $_GET['url'] ?? "";
        $url = trim($url, "/");
        $parts = explode("/", $url);

        // Mặc định user/HomeController@index
        $role = $parts[0] ?: "user";
        $controllerName = $parts[1] ?? "Home";
        $action = $parts[2] ?? "index";

        $controllerFile = __DIR__ . "/../Controllers/{$role}/{$controllerName}Controller.php";

        if (!file_exists($controllerFile)) {
            die("Controller không tồn tại: $controllerFile");
        }
        require_once $controllerFile;

        $className = $controllerName . "Controller";
        $controller = new $className();

        if (!method_exists($controller, $action)) {
            die("Action không tồn tại: $action");
        }

        // Gọi action
        $params = array_slice($parts, 3);
        call_user_func_array([$controller, $action], $params);
    }
}
