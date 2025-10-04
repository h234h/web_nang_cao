<?php
// app/Core/Database.php
require_once __DIR__ . "/Config.php";

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, Config::DB_USER, Config::DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối DB thất bại: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
