<?php
// app/Models/Dashboard.php
require_once __DIR__ . "/../Core/BaseModel.php";

class Dashboard extends BaseModel
{
    public function getTotalProducts()
    {
        // sanpham -> product
        $sql = "SELECT COUNT(*) AS total FROM `product`";
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getTotalOrders()
    {
        // donhang -> `order` (từ khóa -> cần backtick)
        $sql = "SELECT COUNT(*) AS total FROM `order`";
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getTotalUsers()
    {
        // taikhoan -> user ; role=1 là khách
        $sql = "SELECT COUNT(*) AS total FROM `user` WHERE `role` = 1";
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getTotalRevenue()
    {
        // donhang.tongdh/ship_fee không còn trong schema mới.
        // Dùng view v_order_subtotals (subtotal, revenue_excl_shipping) + trạng thái đơn từ bảng `order`.
        $sql = "SELECT COALESCE(SUM(s.revenue_excl_shipping), 0) AS total
                FROM `v_order_subtotals` s
                JOIN `order` o ON o.order_id = s.order_id
                WHERE o.status IN (1,2,3,4)";
        return $this->fetch($sql)["total"] ?? 0;
    }

    public function getRecentOrders($limit = 5)
    {
        $limit = (int)$limit; // ép kiểu an toàn

        $sql = "SELECT 
                o.order_id      AS id_dh,
                u.full_name     AS fullname,
                COALESCE(s.subtotal, 0) AS tongdh,
                o.status        AS status,
                o.order_date    AS ngaydat
            FROM `order` o
            JOIN `user` u ON u.user_id = o.user_id
            LEFT JOIN `v_order_subtotals` s ON s.order_id = o.order_id
            ORDER BY o.order_date DESC
            LIMIT $limit"; // << chèn trực tiếp số

        return $this->fetchAll($sql);
    }
}
