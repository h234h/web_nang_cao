<?php
require_once __DIR__ . "/../Core/BaseModel.php";

class Product extends BaseModel
{
    protected $table = "product";

    // Lấy danh sách có kèm tên danh mục
    public function getAll()
    {
        $sql = "SELECT 
                    p.*,
                    c.category_name AS category_name
                FROM product p
                LEFT JOIN category c ON c.category_id = p.category_id
                ORDER BY p.product_id DESC";
        return $this->fetchAll($sql);
    }

    public function getByName($name)
    {
        $sql = "SELECT * FROM {$this->table} WHERE LOWER(name) = LOWER(:name) LIMIT 1";
        return $this->fetch($sql, [':name' => $name]);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM product WHERE product_id = :id";
        return $this->fetch($sql, [':id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO product 
                (name, maker, price, created_at, image_url, description, quantity, sale_percent, category_id)
                VALUES (:Name, :Maker, :Price, NOW(), :image, :Decribe, :Mount, :Sale, :id_danhmuc)";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
            ':Maker'      => $data['maker'] ?? null,
            ':Price'      => $data['Price'],
            ':image'      => $data['image'],
            ':Decribe'    => $data['Decribe'] ?? null,
            ':Mount'      => $data['Mount'],
            ':Sale'       => $data['Sale'] ?? 0,
            ':id_danhmuc' => $data['id_danhmuc'],
        ]);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE product SET 
                    name = :Name,
                    maker = :Maker,
                    price = :Price,
                    image_url = :image,
                    description = :Decribe,
                    quantity = :Mount,
                    sale_percent = :Sale,
                    category_id = :id_danhmuc
                WHERE product_id = :id";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
            ':Maker'      => $data['maker'] ?? null,
            ':Price'      => $data['Price'],
            ':image'      => $data['image'],
            ':Decribe'    => $data['Decribe'] ?? null,
            ':Mount'      => $data['Mount'],
            ':Sale'       => $data['Sale'] ?? 0,
            ':id_danhmuc' => $data['id_danhmuc'],
            ':id'         => $id
        ]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM product WHERE product_id = :id";
        return $this->execute($sql, [':id' => $id]);
    }

    // (Nếu dùng cho phía user)
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
