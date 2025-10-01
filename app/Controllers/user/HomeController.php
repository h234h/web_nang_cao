<?php
// app/Controllers/user/HomeController.php
require_once __DIR__ . "/../../Models/Product.php";
require_once __DIR__ . "/../../Core/BaseController.php";

class HomeController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function index() // ← đây chính là "home/index"
    {
        $products = $this->productModel->getAllActive();
        $this->view("user/home", ["products" => $products]);
    }

    public function detail($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product || $product['status'] == 0) {
            $this->view("user/404");
            return;
        }
        $this->view("user/product_detail", ["product" => $product]);
    }
}
