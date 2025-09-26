<?php
require_once __DIR__ . "/../../Models/Product.php";
require_once __DIR__ . "/../../Models/Category.php";

class ProductController extends BaseController
{
    protected $product;
    protected $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    // List sản phẩm
    public function index()
    {
        $products = $this->product->getAll();
        $this->view("admin/product/index", ["products" => $products]);
    }

    // Form thêm/sửa
    public function form($id = null)
    {
        $product = null;
        if ($id) {
            $product = $this->product->getById($id);
        }

        $categories = $this->category->getAll();
        $this->view("admin/product/form", [
            "product" => $product,
            "categories" => $categories
        ]);
    }
    public function save()
    {
        $id = $_POST['id'] ?? null;

        $data = [
            'Name'       => trim($_POST['Name'] ?? ''),
            'Price'      => (float)($_POST['Price'] ?? 0),
            'Decribe'    => trim($_POST['Decribe'] ?? ''),
            'Mount'      => (int)($_POST['Mount'] ?? 0),
            'Sale'       => (int)($_POST['Sale'] ?? 0),
            'id_danhmuc' => (int)($_POST['id_danhmuc'] ?? 0),
            'status'     => isset($_POST['status']) ? 1 : 0,
            'image'      => '' // Sẽ gán bên dưới
        ];

        // Giữ ảnh cũ nếu có id
        $old = $id ? $this->product->getById($id) : null;
        if ($old && !empty($old['image'])) {
            $data['image'] = $old['image'];
        }

        // Kiểm tra trùng tên
        $existing = $this->product->getByName($data['Name']);
        if ($existing && (!$id || $existing['id_sp'] != $id)) {
            $categories = $this->category->getAll();
            $this->view("admin/product/form", [
                "product"    => $old,
                "categories" => $categories,
                "errors"     => ["Name" => "Tên sản phẩm đã tồn tại."],
                "old"        => $_POST,
            ]);
            return;
        }

        // Upload ảnh mới nếu chọn
        if (!empty($_FILES['image']['tmp_name'])) {
            $filename  = time() . "_" . preg_replace('/\s+/', '_', basename($_FILES['image']['name']));
            $targetDir = __DIR__ . "/../../../public/uploads/products/";
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $filename)) {
                $data['image'] = $filename;
            }
        } else {
            if (!$id && $data['image'] === '') {
                $categories = $this->category->getAll();
                $this->view("admin/product/form", [
                    "product"    => null,
                    "categories" => $categories,
                    "errors"     => ["image" => "Vui lòng chọn ảnh sản phẩm."],
                    "old"        => $_POST,
                ]);
                return;
            }
        }

        // Validate cơ bản
        $errors = [];
        if (!$data['Name']) $errors['Name'] = "Tên sản phẩm bắt buộc.";
        if ($data['Price'] <= 0) $errors['Price'] = "Giá phải lớn hơn 0.";
        if ($data['Mount'] <= 0) $errors['Mount'] = "Hàng tồn phải > 0.";

        if (!empty($errors)) {
            $categories = $this->category->getAll();
            $this->view("admin/product/form", [
                "product"    => $old,
                "categories" => $categories,
                "errors"     => $errors,
                "old"        => $_POST,
            ]);
            return;
        }

        // Lưu vào DB
        if ($id) {
            $this->product->updateProduct($id, $data);
        } else {
            $this->product->create($data);
        }

        $this->redirect("admin/Product/index");
    }




    // Xóa sản phẩm
    public function delete($id)
    {
        $this->product->deleteProduct($id);
        $this->redirect("admin/Product/index");
    }
}
