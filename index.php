<?php
// index.php (ngoài public)
// File khởi động chính

require_once __DIR__ . "/app/Core/Router.php";
require_once __DIR__ . "/app/Core/BaseController.php";
require_once __DIR__ . "/app/Core/BaseModel.php";

$router = new Router();
$router->run();
