<?php
require_once __DIR__ . "/../Core/BaseModel.php";

class Product extends BaseModel
{
    // Đổi tên bảng: sanpham -> product
    protected $table = "product";

    public function getAll()
    {
        // id_sp -> product_id ; sanpham -> product
        $sql = "SELECT * FROM product ORDER BY product_id DESC";
        return $this->fetchAll($sql);
    }

    public function getByName($name)
    {
        // Name -> name ; {$this->table} đã là product
        $sql = "SELECT * FROM {$this->table} WHERE LOWER(name) = LOWER(:name) LIMIT 1";
        return $this->fetch($sql, [':name' => $name]);
    }

    public function getById($id)
    {
        // sanpham -> product ; id_sp -> product_id
        $sql = "SELECT * FROM product WHERE product_id = :id";
        return $this->fetch($sql, [':id' => $id]);
    }

    public function create($data)
    {
        // Map cột:
        // Name -> name
        // Price -> price
        // image -> image_url
        // Decribe -> description
        // Mount -> quantity
        // Sale -> sale_percent
        // id_danhmuc -> category_id
        // Date_import -> created_at (DB đã default CURRENT_TIMESTAMP, vẫn có thể để NOW())
        $sql = "INSERT INTO product 
            (name, price, created_at, image_url, description, quantity, sale_percent, category_id)
            VALUES (:Name, :Price, NOW(), :image, :Decribe, :Mount, :Sale, :id_danhmuc)";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
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
        // sanpham -> product ; các cột đổi sang schema mới
        // updated_at trong DB tự cập nhật ON UPDATE CURRENT_TIMESTAMP nên không cần set
        $sql = "UPDATE product SET 
            name = :Name,
            price = :Price,
            image_url = :image,
            description = :Decribe,
            quantity = :Mount,
            sale_percent = :Sale,
            category_id = :id_danhmuc
            WHERE product_id = :id";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
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
        // sanpham -> product ; id_sp -> product_id
        $sql = "DELETE FROM product WHERE product_id = :id";
        return $this->execute($sql, [':id' => $id]);
    }

    // USER
    public function getAllActive()
    {
        // DB không có cột 'status' trong bảng product -> bỏ điều kiện status
        $sql = "SELECT * FROM {$this->table} ORDER BY product_id DESC";
        return $this->fetchAll($sql);
    }
}
