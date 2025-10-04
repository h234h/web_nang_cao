<?php
// index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/app/Core/Router.php";
require_once __DIR__ . "/app/Core/BaseController.php";
require_once __DIR__ . "/app/Core/BaseModel.php";

$router = new Router();
$router->run();
