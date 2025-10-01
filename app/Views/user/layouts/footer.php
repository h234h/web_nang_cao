<?php
$header = __DIR__ . '/../layouts/header.php';
if (!file_exists($header)) {
    $header = __DIR__ . '/../admin/layouts/header.php';
}
require_once $header;
