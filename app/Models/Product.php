<?php
require_once __DIR__ . "/../Core/BaseModel.php";

class Product extends BaseModel
{
    protected $table = "product";

    public function getAll()
    {
        $sql = "SELECT 
                    p.*,
                    c.category_name AS category_name
                FROM {$this->table} p
                LEFT JOIN category c ON c.category_id = p.category_id
                ORDER BY p.product_id DESC";
        return $this->fetchAll($sql);
    }
    public function getByCategory($categoryId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE category_id = :id";
        return $this->fetchAll($sql, [':id' => $categoryId]);
    }

    public function getByName($name)
    {
        $sql = "SELECT * FROM {$this->table} WHERE LOWER(name) = LOWER(:name) LIMIT 1";
        return $this->fetch($sql, [':name' => $name]);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = :id";
        return $this->fetch($sql, [':id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (name, maker, price, created_at, image_url, description, quantity, sale_percent, category_id)
                VALUES (:Name, :Maker, :Price, NOW(), :image_url, :Decribe, :Mount, :Sale, :id_danhmuc)";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
            ':Maker'      => $data['maker'] ?? null,
            ':Price'      => $data['Price'],
            ':image_url'  => $data['image_url'],
            ':Decribe'    => $data['Decribe'] ?? null,
            ':Mount'      => $data['Mount'],
            ':Sale'       => $data['Sale'] ?? 0,
            ':id_danhmuc' => $data['id_danhmuc'],
        ]);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                    name = :Name,
                    maker = :Maker,
                    price = :Price,
                    image_url = :image_url,
                    description = :Decribe,
                    quantity = :Mount,
                    sale_percent = :Sale,
                    category_id = :id_danhmuc
                WHERE product_id = :id";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
            ':Maker'      => $data['maker'] ?? null,
            ':Price'      => $data['Price'],
            ':image_url'  => $data['image_url'],
            ':Decribe'    => $data['Decribe'] ?? null,
            ':Mount'      => $data['Mount'],
            ':Sale'       => $data['Sale'] ?? 0,
            ':id_danhmuc' => $data['id_danhmuc'],
            ':id'         => $id
        ]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE product_id = :id";
        return $this->execute($sql, [':id' => $id]);
    }

    public function getAllActive()
    {
        $sql = "SELECT 
                    p.*,
                    c.category_name AS category_name
                FROM {$this->table} p
                LEFT JOIN category c ON c.category_id = p.category_id
                ORDER BY p.product_id DESC";
        return $this->fetchAll($sql);
    }
}
