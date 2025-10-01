<?php
// app/Models/User.php
require_once __DIR__ . "/../Core/BaseModel.php";

class User extends BaseModel
{
    protected $table = "taikhoan";

    // Login bằng email hoặc username
    public function login($emailOrUsername, $password)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (username = :eu OR email = :eu) 
                  AND password = :pass
                LIMIT 1";
        $user = $this->fetch($sql, [
            ':eu'   => $emailOrUsername,
            ':pass' => md5($password)
        ]);

        return $user ?: false;
    }
}
