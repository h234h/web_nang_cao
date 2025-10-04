<?php
require_once __DIR__ . "/../../Core/BaseController.php";
require_once __DIR__ . "/../../Models/Cart.php";
require_once __DIR__ . "/../../Models/Product.php";

class CartController extends BaseController
{
    private $cartModel;
    private $productModel;

    public function __construct()
    {
        $this->cartModel    = new Cart();
        $this->productModel = new Product();
    }

    // Trang giỏ hàng
    public function index()
    {
        if (empty($_SESSION['user']['user_id'])) {
            $this->redirect("user/Auth/login");
        }

        $userId = $_SESSION['user']['user_id'];
        $cart   = $this->cartModel->getOrCreateCart($userId);

        $items = $this->cartModel->getItems($cart['cart_id']);
        $total = array_sum(array_map(fn($it) => $it['price'] * $it['quantity'], $items));

        $this->view("user/cart/index", [
            "items" => $items,
            "total" => $total
        ]);
    }

    // Thêm sản phẩm
    public function add($productId)
    {
        if (empty($_SESSION['user']['user_id'])) {
            $this->redirect("user/Auth/login");
        }

        $userId = $_SESSION['user']['user_id'];
        $cart   = $this->cartModel->getOrCreateCart($userId);

        $this->cartModel->addItem($cart['cart_id'], $productId, 1);

        // cập nhật badge
        $_SESSION['cart_count'] = $this->cartModel->countItems($cart['cart_id']);

        $this->redirect("user/home");
    }

    // Xóa sản phẩm trong giỏ
    public function remove($productId)
    {
        if (empty($_SESSION['user']['user_id'])) {
            $this->redirect("user/Auth/login");
        }

        $userId = $_SESSION['user']['user_id'];
        $cart   = $this->cartModel->getOrCreateCart($userId);

        $this->cartModel->deleteItem($cart['cart_id'], $productId);
        $_SESSION['cart_count'] = $this->cartModel->countItems($cart['cart_id']);

        $this->redirect("user/cart/index");
    }
}
