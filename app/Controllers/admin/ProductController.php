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

    public function index()
    {
        $products = $this->product->getAll();
        $this->view("admin/product/index", ["products" => $products]);
    }

    public function form($id = null)
    {
        $product = null;
        if ($id) {
            $product = $this->product->getById($id);
        }

        $categories  = $this->category->getAll();
        $allProducts = $this->product->getAll();

        $this->view("admin/product/form", [
            "product"     => $product,
            "categories"  => $categories,
            "allProducts" => $allProducts
        ]);
    }

    public function save()
    {
        $id = $_POST['id'] ?? null;

        $data = [
            'Name'       => trim($_POST['Name'] ?? ''),
            'maker'      => trim($_POST['maker'] ?? ''),
            'Price'      => (float)($_POST['Price'] ?? 0),
            'Decribe'    => trim($_POST['Decribe'] ?? ''),
            'Mount'      => (int)($_POST['Mount'] ?? 0),
            'Sale'       => (int)($_POST['Sale'] ?? 0),
            'id_danhmuc' => (int)($_POST['id_danhmuc'] ?? 0),
            'status'     => isset($_POST['status']) ? 1 : 0,
            'image_url'  => ''
        ];

        $old = $id ? $this->product->getById($id) : null;
        if ($old && !empty($old['image_url'])) {
            $data['image_url'] = $old['image_url'];
        }

        $errors = [];
        if (!$data['Name']) $errors['Name'] = "Tên sản phẩm bắt buộc.";
        if ($data['Price'] <= 0) $errors['Price'] = "Giá phải lớn hơn 0.";
        if ($data['Mount'] <= 0) $errors['Mount'] = "Hàng tồn phải > 0.";

        if (!$id && empty($_FILES['image']['tmp_name'])) {
            $errors['image'] = "Vui lòng chọn ảnh sản phẩm.";
        }

        if (!empty($errors)) {
            $categories  = $this->category->getAll();
            $allProducts = $this->product->getAll();
            $this->view("admin/product/form", [
                "product"     => $old,
                "categories"  => $categories,
                "allProducts" => $allProducts,
                "errors"      => $errors,
                "old"         => $_POST,
            ]);
            return;
        }

        if (!empty($_FILES['image']['tmp_name'])) {
            $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
            $originalName = preg_replace('/\s+/', '_', $originalName);
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = $originalName . "_" . time() . "." . $extension;

            $targetDir = __DIR__ . "/../../../public/uploads/products/";
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $filename)) {
                if ($old && !empty($old['image_url']) && file_exists($targetDir . $old['image_url'])) {
                    unlink($targetDir . $old['image_url']);
                }
                $data['image_url'] = $filename;
            }
        }

        if ($id) {
            $this->product->updateProduct($id, $data);
        } else {
            $this->product->create($data);
        }

        $this->redirect("admin/Product/index");
    }

    public function delete($id)
    {
        $product = $this->product->getById($id);

        if ($product) {
            $imagePath = __DIR__ . "/../../../public/uploads/products/" . ($product['image_url'] ?? '');
            if (!empty($product['image_url']) && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $this->product->deleteProduct($id);
        }

        $this->redirect("admin/Product/index");
    }
}
