<?php
// app/Controllers/admin/CategoryController.php
require_once __DIR__ . "/../../Models/Category.php";

class CategoryController extends BaseController
{
    protected $category;

    public function __construct()
    {
        $this->category = new Category();
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

        // Lấy danh sách tên hiện có để kiểm tra trùng
        $categories = $this->category->getAll();
        $names = array_column($categories, 'name');

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

        // Lấy tất cả danh mục để check trùng
        $categories = $this->category->getAll();
        $names = array_map('mb_strtolower', array_column($categories, 'name'));
        if ($id) {
            $current = $this->category->getById($id)['name'];
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

    // Xóa
    public function delete($id)
    {
        $this->category->deleteCategory($id);
        $this->redirect("admin/Category/index");
    }
}
