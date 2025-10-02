<?php
// app/Models/User.php
require_once __DIR__ . "/../Core/BaseModel.php";

class User extends BaseModel
{
    protected $table = "user";

    // Tìm user theo username hoặc email
    public function findByUsernameOrEmail($identifier)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :identifier OR email = :identifier LIMIT 1";
        return $this->fetch($sql, [':identifier' => $identifier]);
    }

    // Tìm user theo email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        return $this->fetch($sql, [':email' => $email]);
    }

    // Kiểm tra username đã tồn tại chưa
    public function existsByUsername($username)
    {
        $sql = "SELECT user_id FROM {$this->table} WHERE username = :username LIMIT 1";
        $result = $this->fetch($sql, [':username' => $username]);
        return $result ? true : false;
    }

    // Kiểm tra email đã tồn tại chưa
    public function existsByEmail($email)
    {
        $sql = "SELECT user_id FROM {$this->table} WHERE email = :email LIMIT 1";
        $result = $this->fetch($sql, [':email' => $email]);
        return $result ? true : false;
    }

    // Đăng ký user mới
    public function create($username, $full_name, $password, $email, $phone = null, $address = null, $role = 1)
    {
        $sql = "INSERT INTO {$this->table} (username, full_name, password, email, phone, address, role, account_status) 
                VALUES (:username, :full_name, :password, :email, :phone, :address, :role, 1)";
        return $this->execute($sql, [
            ':username' => $username,
            ':full_name' => $full_name,
            ':password' => md5($password), // ⚠ dùng md5 đúng chuẩn db
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':role' => $role
        ]);
    }
}
