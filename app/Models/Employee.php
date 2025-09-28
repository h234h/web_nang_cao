<?php
// app/models/Employee.php
require_once __DIR__ . "/../Core/BaseModel.php";

class Employee extends BaseModel
{
    // 📌 Lấy tất cả nhân viên (role = 2)
    public function all()
    {
        return $this->fetchAll("SELECT * FROM taikhoan WHERE role = 2");
    }

    // 📌 Tìm nhân viên theo id
    public function find($id)
    {
        return $this->fetch("SELECT * FROM taikhoan WHERE id_user = :id AND role = 2", [":id" => $id]);
    }

    // 📌 Thêm nhân viên mới
    public function insert($data)
    {
        $sql = "INSERT INTO taikhoan 
                (username, password, fullname, email, phone, address, role, status, created_at, updated_at) 
                VALUES (:username, :password, :fullname, :email, :phone, :address, 2, :status, NOW(), NOW())";
        return $this->execute($sql, $data);
    }

    // 📌 Cập nhật thông tin nhân viên
    public function update($id, $data)
    {
        $fields = [
            "username = :username",
            "fullname = :fullname",
            "email = :email",
            "phone = :phone",
            "address = :address",
            "status = :status"
        ];

        // Nếu có mật khẩu mới thì cập nhật, không thì bỏ qua
        if (!empty($data[":password"])) {
            $fields[] = "password = :password";
        } else {
            unset($data[":password"]);
        }

        $data[":id"] = $id;

        $sql = "UPDATE taikhoan 
                SET " . implode(", ", $fields) . ", updated_at = NOW()
                WHERE id_user = :id AND role = 2";

        return $this->execute($sql, $data);
    }

    // 📌 Kiểm tra username đã tồn tại chưa
    public function existsUsername($username, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as cnt FROM taikhoan WHERE username = :username AND role = 2";
        $params = [":username" => $username];

        // Nếu đang update thì bỏ qua id hiện tại
        if ($excludeId) {
            $sql .= " AND id_user != :id";
            $params[":id"] = $excludeId;
        }

        $row = $this->fetch($sql, $params);
        return $row["cnt"] > 0;
    }

    // 📌 Kiểm tra email đã tồn tại chưa
    public function existsEmail($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as cnt FROM taikhoan WHERE email = :email AND role = 2";
        $params = [":email" => $email];

        // Nếu đang update thì bỏ qua id hiện tại
        if ($excludeId) {
            $sql .= " AND id_user != :id";
            $params[":id"] = $excludeId;
        }

        $row = $this->fetch($sql, $params);
        return $row["cnt"] > 0;
    }
}
