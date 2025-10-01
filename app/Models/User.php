<?php
// app/Models/User.php
require_once __DIR__ . '/../Core/BaseModel.php';

class User extends BaseModel
{
    protected $table = 'taikhoan';

    public function findByUsername(string $username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :u LIMIT 1";
        return $this->fetch($sql, [':u' => $username]); // dùng fetch() của BaseModel
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :e LIMIT 1";
        return $this->fetch($sql, [':e' => $email]);
    }

    public function create(array $data)
    {
        // DB hiện đang lưu MD5 → để khớp dữ liệu có sẵn.
        $sql = "INSERT INTO {$this->table}
                (username, password, fullname, email, phone, address, role, status, created_at)
                VALUES (:username, :password, :fullname, :email, :phone, :address, :role, :status, NOW())";
        $params = [
            ':username' => $data['username'],
            ':password' => md5($data['password']),   // nếu chuyển bcrypt, đổi chỗ này + verifyLogin()
            ':fullname' => $data['fullname'],
            ':email'    => $data['email'],
            ':phone'    => $data['phone'] ?? '',
            ':address'  => $data['address'] ?? '',
            ':role'     => 1,   // user
            ':status'   => 1,
        ];
        return $this->execute($sql, $params);        // dùng execute() của BaseModel
    }

    public function verifyLogin(string $username, string $password)
    {
        $user = $this->findByUsername($username);
        if (!$user) return false;

        // Khớp với MD5 trong DB hiện tại:
        $ok = (md5($password) === $user['password']);
        // Nếu dùng bcrypt sau này: $ok = password_verify($password, $user['password']);

        if (!$ok) return false;
        if ((int)$user['status'] !== 1) return false;

        return $user;
    }
}
