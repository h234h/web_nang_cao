<?php
// app/Core/BaseModel.php
require_once __DIR__ . "/Database.php";

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    protected function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function execute($sql, $params = [])
    {
        return $this->query($sql, $params);
    }
}
