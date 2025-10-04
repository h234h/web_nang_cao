<?php
require_once __DIR__ . "/../Core/BaseModel.php";

class Cart extends BaseModel
{
    protected $tableCart = "cart";
    protected $tableItem = "cart_item";

    // Tìm hoặc tạo giỏ hàng của user
    public function getOrCreateCart($userId)
    {
        $cart = $this->fetch("SELECT * FROM {$this->tableCart} WHERE user_id = :uid", [":uid" => $userId]);
        if ($cart) return $cart;

        $this->execute("INSERT INTO {$this->tableCart}(user_id, created_at) VALUES(:uid, NOW())", [":uid" => $userId]);
        return $this->fetch("SELECT * FROM {$this->tableCart} WHERE user_id = :uid", [":uid" => $userId]);
    }

    // Thêm sản phẩm vào giỏ
    public function addItem($cartId, $productId, $qty = 1)
    {
        $item = $this->fetch("SELECT * FROM {$this->tableItem} WHERE cart_id = :cid AND product_id = :pid", [
            ":cid" => $cartId,
            ":pid" => $productId
        ]);

        if ($item) {
            $this->execute("UPDATE {$this->tableItem} SET quantity = quantity + :qty WHERE cart_item_id = :iid", [
                ":qty" => $qty,
                ":iid" => $item['cart_item_id']
            ]);
        } else {
            $this->execute("INSERT INTO {$this->tableItem}(cart_id, product_id, quantity) VALUES(:cid, :pid, :qty)", [
                ":cid" => $cartId,
                ":pid" => $productId,
                ":qty" => $qty
            ]);
        }
    }

    // Xóa 1 sản phẩm
    public function deleteItem($cartId, $productId)
    {
        $this->execute("DELETE FROM {$this->tableItem} WHERE cart_id = :cid AND product_id = :pid", [
            ":cid" => $cartId,
            ":pid" => $productId
        ]);
    }

    // Lấy tất cả item trong giỏ
    public function getItems($cartId)
    {
        $sql = "SELECT ci.*, p.name, p.price, p.image_url
                FROM {$this->tableItem} ci
                JOIN product p ON p.product_id = ci.product_id
                WHERE ci.cart_id = :cid";
        return $this->fetchAll($sql, [":cid" => $cartId]);
    }

    // Đếm tổng số lượng item
    public function countItems($cartId)
    {
        $row = $this->fetch("SELECT SUM(quantity) AS total FROM {$this->tableItem} WHERE cart_id = :cid", [
            ":cid" => $cartId
        ]);
        return (int)($row['total'] ?? 0);
    }
}
