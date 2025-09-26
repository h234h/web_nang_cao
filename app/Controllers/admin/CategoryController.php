<?php
// app/Controllers/admin/CategoryController.php
require_once __DIR__ . "/../../Core/BaseController.php";
require_once __DIR__ . "/../../Models/Category.php";

class CategoryController extends BaseController
{
    protected $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = $this->category->getAll();
        $this->view("admin/category/index", ["categories" => $categories]);
    }

    // Form thêm/sửa danh mục
    public function form($id = null)
    {
        $category = null;
        if ($id) {
            $category = $this->category->getById($id);
        }
        $this->view("admin/category/form", ["category" => $category]);
    }

    // Lưu dữ liệu (thêm hoặc sửa) với kiểm tra trùng tên
    public function save()
    {
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? "");

        if (!$name) {
            die("Tên danh mục không được để trống");
        }

        // Kiểm tra tên danh mục đã tồn tại
        $existing = $this->category->getByName($name);
        if ($existing && (!$id || $existing['id'] != $id)) {
            die("Tên danh mục đã tồn tại: " . htmlspecialchars($name));
        }

        if ($id) {
            $this->category->updateCategory($id, $name);
        } else {
            $this->category->create($name);
        }

        $this->redirect("admin/Category/index");
    }


    // Xóa danh mục
    public function delete($id)
    {
        $this->category->deleteCategory($id);
        $this->redirect("admin/Category/index");
    }
}
