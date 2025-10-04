<?php
require_once __DIR__ . "/../Core/BaseModel.php";

class User extends BaseModel
{
    protected $table = "user";

    // Đăng nhập: lấy theo username hoặc email
    public function getByIdentifier(string $identifier)
    {
        $sql = "SELECT * FROM user WHERE username = :id OR email = :id LIMIT 1";
        return $this->fetch($sql, [":id" => $identifier]);
    }

    // Đăng ký: kiểm tra trùng
    public function existsUsername(string $username): bool
    {
        $row = $this->fetch("SELECT COUNT(*) c FROM user WHERE username = :u", [":u" => $username]);
        return (int)$row['c'] > 0;
    }
    public function existsEmail(string $email): bool
    {
        $row = $this->fetch("SELECT COUNT(*) c FROM user WHERE email = :e", [":e" => $email]);
        return (int)$row['c'] > 0;
    }

    // Tạo user mới (mặc định role=1)
    public function create(array $data)
    {
        $sql = "INSERT INTO user (username, full_name, password, email, phone, address, role, account_status, created_at)
                VALUES (:u, :name, :pw, :email, :phone, :addr, :role, 1, NOW())";
        return $this->execute($sql, [
            ":u"     => $data["username"],
            ":name"  => $data["full_name"] ?? null,
            ":pw"    => $data["password"],            // ĐÃ md5 sẵn từ controller
            ":email" => $data["email"],
            ":phone" => $data["phone"]  ?? null,
            ":addr"  => $data["address"] ?? null,
            ":role"  => $data["role"]   ?? 1,
        ]);
    }
}
