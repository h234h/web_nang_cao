<?php
// app/Models/Category.php
require_once __DIR__ . "/../Core/BaseModel.php";

class Category extends BaseModel
{
    protected $table = "category";

    // Lấy tất cả danh mục
    public function getAll()
    {
        // đúng: category_id
        $sql = "SELECT * FROM category ORDER BY category_id DESC";
        return $this->fetchAll($sql);
    }

    // Lấy danh mục theo id
    public function getById($id)
    {
        // đúng: category_id
        $sql = "SELECT * FROM category WHERE category_id = :id";
        return $this->fetch($sql, [':id' => $id]);
    }

    public function getByName($name)
    {
        // đúng: category_name
        $sql = "SELECT * FROM category WHERE category_name = :name LIMIT 1";
        return $this->fetch($sql, [':name' => $name]);
    }

    // Tạo mới danh mục
    public function create($name)
    {
        // đúng: category_name (+ created_at nếu muốn)
        $sql = "INSERT INTO {$this->table} (category_name, created_at) VALUES (:name, NOW())";
        return $this->execute($sql, [':name' => $name]);
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        // đổi danhmuc -> category, id -> category_id
        $sql = "DELETE FROM category WHERE category_id = :id";
        return $this->execute($sql, [':id' => $id]);
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name)
    {
        // đổi danhmuc -> category, name -> category_name, id -> category_id
        $sql = "UPDATE category SET category_name = :name WHERE category_id = :id";
        return $this->execute($sql, [':name' => $name, ':id' => $id]);
    }
}
