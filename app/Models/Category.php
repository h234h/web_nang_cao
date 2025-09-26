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


    // Lấy danh mục theo id
    public function getById($id)
    {
        $sql = "SELECT * FROM danhmuc WHERE id = :id";
        return $this->fetch($sql, ['id' => $id]);
    }
    public function getByName($name)
    {
        $sql = "SELECT * FROM danhmuc WHERE name = :name LIMIT 1";
        return $this->fetch($sql, [':name' => $name]);
    }

    // Tạo mới danh mục
    public function create($name)
    {
        $sql = "INSERT INTO {$this->table} (name) VALUES (:name)";
        return $this->execute($sql, [":name" => $name]);
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        // Sửa id_dm thành id nếu cột chính của bảng là id
        $sql = "DELETE FROM danhmuc WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }



    // Cập nhật danh mục
    public function updateCategory($id, $name)
    {
        $sql = "UPDATE danhmuc SET name = :name WHERE id = :id";
        return $this->execute($sql, ['name' => $name, 'id' => $id]);
    }
}
