    <?php
    require_once __DIR__ . "/../../Core/BaseController.php";
    require_once __DIR__ . "/../../Models/Product.php";

    class ProductController extends BaseController
    {
        private $product;

        public function __construct()
        {
            $this->product = new Product();
        }

        // Hiển thị chi tiết sản phẩm
        public function detail($id)
        {
            $product = $this->product->getById($id);
            if (!$product) {
                die("Sản phẩm không tồn tại");
            }

            // Lấy sản phẩm liên quan trong cùng danh mục (trừ chính nó)
            $related = [];
            if (!empty($product['category_id'])) {
                $related = $this->product->getByCategory($product['category_id']);
                $related = array_filter($related, function ($r) use ($id) {
                    return $r['product_id'] != $id;
                });
            }

            $this->view("user/product/detail", [
                "product" => $product,
                "related" => $related
            ]);
        }
    }
