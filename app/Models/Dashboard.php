<?php
// app/Models/Dashboard.php
require_once __DIR__ . "/../Core/BaseModel.php";

class Dashboard extends BaseModel
{

    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) AS total FROM sanpham";
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getTotalOrders()
    {
        $sql = "SELECT COUNT(*) AS total FROM donhang";
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getTotalUsers()
    {
        $sql = "SELECT COUNT(*) AS total FROM taikhoan WHERE role = 1"; // khách hàng
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getTotalRevenue()
    {
        $sql = "SELECT COALESCE(SUM(tongdh - discount + ship_fee),0) AS total
                FROM donhang
                WHERE status IN (1,2,3,4)"; // chỉ tính đơn đã xác nhận/giao thành công
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getRecentOrders($limit = 5)
    {
        $sql = "SELECT dh.id_dh, tk.fullname, dh.tongdh, dh.status, dh.ngaydat
                FROM donhang dh
                JOIN taikhoan tk ON tk.id_user = dh.id_user
                ORDER BY dh.created_at DESC
                LIMIT :lim";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":lim", (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
