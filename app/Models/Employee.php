<?php
// app/models/Employee.php
require_once __DIR__ . "/../Core/BaseModel.php";

class Employee extends BaseModel
{
    // 📌 Lấy tất cả nhân viên
    public function all()
    {
        // Đổi: taikhoan -> employee
        return $this->fetchAll("SELECT * FROM employee ORDER BY employee_id DESC");
    }

    // 📌 Tìm nhân viên theo id
    public function find($id)
    {
        // Đổi: taikhoan.id_user -> employee.employee_id
        return $this->fetch(
            "SELECT * FROM employee WHERE employee_id = :id",
            [":id" => $id]
        );
    }

    // 📌 Thêm nhân viên mới
    public function insert($data)
    {
        // Bảng employee có các cột: full_name, email, phone, address, position, hired_at, account_status, note, created_at
        // Map dữ liệu đang truyền từ controller:
        // - :fullname  -> full_name
        // - :email     -> email
        // - :phone     -> phone
        // - :address   -> address
        // - :status    -> account_status
        // (username/password/role không tồn tại trong bảng employee -> bỏ qua)
        $sql = "INSERT INTO employee 
                (full_name, email, phone, address, position, hired_at, account_status, note, created_at)
                VALUES (:full_name, :email, :phone, :address, :position, :hired_at, :account_status, :note, NOW())";

        // Chuẩn hoá mảng tham số từ $data hiện tại (giữ nguyên key cũ, chỉ ánh xạ sang key mới)
        $params = [
            ':full_name'      => $data[':fullname'] ?? $data['fullname'] ?? null,
            ':email'          => $data[':email']    ?? $data['email']    ?? null,
            ':phone'          => $data[':phone']    ?? $data['phone']    ?? null,
            ':address'        => $data[':address']  ?? $data['address']  ?? null,
            ':position'       => $data[':position'] ?? $data['position'] ?? null,    // nếu controller không truyền, sẽ là null
            ':hired_at'       => $data[':hired_at'] ?? $data['hired_at'] ?? null,    // có thể null
            ':account_status' => $data[':status']   ?? $data['status']   ?? 1,       // map status -> account_status
            ':note'           => $data[':note']     ?? $data['note']     ?? null,
        ];

        return $this->execute($sql, $params);
    }

    // 📌 Cập nhật thông tin nhân viên
    public function update($id, $data)
    {
        // Đổi sang cột của employee; không có updated_at trong schema -> không set
        // Map từ key cũ sang cột mới:
        // username -> (không tồn tại)    => bỏ qua
        // fullname -> full_name
        // email    -> email
        // phone    -> phone
        // address  -> address
        // status   -> account_status
        $fieldsSql = [
            "full_name = :full_name",
            "email = :email",
            "phone = :phone",
            "address = :address",
            "account_status = :account_status",
        ];

        // Nếu có truyền thêm position / hired_at / note thì cập nhật
        if (isset($data[':position']) || isset($data['position'])) {
            $fieldsSql[] = "position = :position";
        }
        if (isset($data[':hired_at']) || isset($data['hired_at'])) {
            $fieldsSql[] = "hired_at = :hired_at";
        }
        if (isset($data[':note']) || isset($data['note'])) {
            $fieldsSql[] = "note = :note";
        }

        $sql = "UPDATE employee 
                SET " . implode(", ", $fieldsSql) . "
                WHERE employee_id = :id";

        $params = [
            ':full_name'      => $data[':fullname'] ?? $data['fullname'] ?? null,
            ':email'          => $data[':email']    ?? $data['email']    ?? null,
            ':phone'          => $data[':phone']    ?? $data['phone']    ?? null,
            ':address'        => $data[':address']  ?? $data['address']  ?? null,
            ':account_status' => $data[':status']   ?? $data['status']   ?? 1,
            ':position'       => $data[':position'] ?? $data['position'] ?? null,
            ':hired_at'       => $data[':hired_at'] ?? $data['hired_at'] ?? null,
            ':note'           => $data[':note']     ?? $data['note']     ?? null,
            ':id'             => $id,
        ];

        return $this->execute($sql, $params);
    }

    // 📌 Kiểm tra username đã tồn tại chưa (map sang full_name cho phù hợp schema)
    public function existsUsername($username, $excludeId = null)
    {
        // employee không có cột username -> kiểm tra trùng full_name để giữ tương thích hàm gọi
        $sql = "SELECT COUNT(*) as cnt FROM employee WHERE full_name = :username";
        $params = [":username" => $username];

        if ($excludeId) {
            $sql .= " AND employee_id != :id";
            $params[":id"] = $excludeId;
        }

        $row = $this->fetch($sql, $params);
        return (int)$row["cnt"] > 0;
    }

    // 📌 Kiểm tra email đã tồn tại chưa
    public function existsEmail($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as cnt FROM employee WHERE email = :email";
        $params = [":email" => $email];

        if ($excludeId) {
            $sql .= " AND employee_id != :id";
            $params[":id"] = $excludeId;
        }

        $row = $this->fetch($sql, $params);
        return (int)$row["cnt"] > 0;
    }
}
