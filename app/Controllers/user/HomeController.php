<?php
// app/Controllers/user/HomeController.php
require_once __DIR__ . "/../../Models/Category.php";
require_once __DIR__ . "/../../Models/Product.php";

class HomeController extends BaseController
{
    protected $category;
    protected $product;

    public function __construct()
    {
        $this->category = new Category();
        $this->product  = new Product();
    }

    public function index()
    {
        // Lấy danh mục
        $categories = $this->category->getAll();

        // Xử lý lọc theo danh mục và giá
        $activeCatId = $_GET['category'] ?? null;
        $minPrice    = isset($_GET['min_price']) ? (int)$_GET['min_price'] : null;
        $maxPrice    = isset($_GET['max_price']) ? (int)$_GET['max_price'] : null;

        // Lấy toàn bộ sản phẩm
        $products = $this->product->getAllActive();

        // Filter thủ công trong PHP (hoặc có thể viết query SQL riêng để lọc)
        if ($activeCatId) {
            $products = array_filter($products, function ($p) use ($activeCatId) {
                return (string)$p['category_id'] === (string)$activeCatId;
            });
        }

        if ($minPrice !== null) {
            $products = array_filter($products, function ($p) use ($minPrice) {
                return (float)$p['price'] >= $minPrice;
            });
        }

        if ($maxPrice !== null) {
            $products = array_filter($products, function ($p) use ($maxPrice) {
                return (float)$p['price'] <= $maxPrice;
            });
        }

        // Pagination
        $page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage  = 12;
        $total    = count($products);
        $totalPages = ceil($total / $perPage);

        $products = array_slice($products, ($page - 1) * $perPage, $perPage);

        // Truyền dữ liệu sang view
        $this->view("user/home", [
            "categories"  => $categories,
            "products"    => $products,
            "total"       => $total,
            "page"        => $page,
            "perPage"     => $perPage,
            "totalPages"  => $totalPages,
            "activeCatId" => $activeCatId,
            "minPrice"    => $minPrice,
            "maxPrice"    => $maxPrice
        ]);
    }
}
