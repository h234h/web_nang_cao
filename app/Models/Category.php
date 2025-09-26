<?php
// app/Models/Category.php
require_once __DIR__ . "/../Core/BaseModel.php";

class Category extends BaseModel
{
    protected $table = "danhmuc";

    // Lấy tất cả danh mục
    public function getAll()
    {
        $sql = "SELECT * FROM danhmuc ORDER BY id DESC";
        return $this->fetchAll($sql);
    }


    // Lấy danh mục theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_dm = :id";
        return $this->fetch($sql, [":id" => $id]);
    }

    // Tạo mới danh mục
    public function create($name)
    {
        $sql = "INSERT INTO {$this->table} (name) VALUES (:name)";
        return $this->execute($sql, [":name" => $name]);
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name)
    {
        $sql = "UPDATE {$this->table} SET name = :name WHERE id_dm = :id";
        return $this->execute($sql, [":name" => $name, ":id" => $id]);
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id_dm = :id";
        return $this->execute($sql, [":id" => $id]);
    }
}
