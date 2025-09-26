<?php
require_once __DIR__ . "/../Core/BaseModel.php";

class Product extends BaseModel
{
    protected $table = "sanpham";

    public function getAll()
    {
        $sql = "SELECT * FROM sanpham ORDER BY id_sp DESC";
        return $this->fetchAll($sql);
    }
    public function getByName($name)
    {
        $sql = "SELECT * FROM {$this->table} WHERE LOWER(Name) = LOWER(:name) LIMIT 1";
        return $this->fetch($sql, [':name' => $name]);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM sanpham WHERE id_sp = :id";
        return $this->fetch($sql, ['id' => $id]);
    }

    public function create($data)
    {
        $sql = "INSERT INTO sanpham 
            (Name, Price, Date_import, image, Decribe, Mount, Sale, id_danhmuc, status)
            VALUES (:Name, :Price, NOW(), :image, :Decribe, :Mount, :Sale, :id_danhmuc, :status)";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
            ':Price'      => $data['Price'],
            ':image'      => $data['image'],
            ':Decribe'    => $data['Decribe'] ?? null,
            ':Mount'      => $data['Mount'],
            ':Sale'       => $data['Sale'] ?? 0,
            ':id_danhmuc' => $data['id_danhmuc'],
            ':status'     => $data['status'] ?? 1
        ]);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE sanpham SET 
            Name=:Name, Price=:Price, image=:image, Decribe=:Decribe, 
            Mount=:Mount, Sale=:Sale, id_danhmuc=:id_danhmuc, status=:status
            WHERE id_sp=:id";
        return $this->execute($sql, [
            ':Name'       => $data['Name'],
            ':Price'      => $data['Price'],
            ':image'      => $data['image'],
            ':Decribe'    => $data['Decribe'] ?? null,
            ':Mount'      => $data['Mount'],
            ':Sale'       => $data['Sale'] ?? 0,
            ':id_danhmuc' => $data['id_danhmuc'],
            ':status'     => $data['status'] ?? 1,
            ':id'         => $id
        ]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM sanpham WHERE id_sp = :id";
        return $this->execute($sql, [':id' => $id]);
    }
}
