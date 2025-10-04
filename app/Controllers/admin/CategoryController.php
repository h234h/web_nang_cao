<?php
// app/Controllers/admin/CategoryController.php
require_once __DIR__ . "/../../Models/Category.php";
require_once __DIR__ . "/../../Models/Product.php";

class CategoryController extends BaseController
{
    protected $category;
    protected $product;

    public function __construct()
    {
        $this->category = new Category();
        $this->product  = new Product();
    }

    // List danh mục
    public function index()
    {
        $categories = $this->category->getAll();
        $this->view("admin/category/index", ["categories" => $categories]);
    }

    // Form thêm/sửa
    public function form($id = null)
    {
        $category = null;
        if ($id) {
            $category = $this->category->getById($id);
        }

        $categories = $this->category->getAll();
        $names = array_column($categories, 'category_name');

        $this->view("admin/category/form", [
            "category" => $category,
            "existingNames" => $names
        ]);
    }

    // Lưu (thêm/sửa)
    public function save()
    {
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name']);

        if (!$name) {
            die("Tên danh mục không được để trống");
        }

        $categories = $this->category->getAll();
        $names = array_map('mb_strtolower', array_column($categories, 'category_name'));

        if ($id) {
            $currentRow = $this->category->getById($id);
            $current = $currentRow['category_name'] ?? '';
            $names = array_filter($names, fn($n) => mb_strtolower($n) !== mb_strtolower($current));
        }

        if (in_array(mb_strtolower($name), $names)) {
            die("Tên danh mục đã tồn tại");
        }

        if ($id) {
            $this->category->updateCategory($id, $name);
        } else {
            $this->category->create($name);
        }

        $this->redirect("admin/Category/index");
    }

    public function delete($id)
    {
        // Kiểm tra sản phẩm thuộc danh mục
        $products = $this->product->getByCategory($id);

        if (!empty($products)) {
            die("Không thể xóa: Danh mục này vẫn còn sản phẩm!");
        }

        // Không có sản phẩm → xóa OK
        $this->category->deleteCategory($id);
        $this->redirect("admin/Category/index");
    }
}
