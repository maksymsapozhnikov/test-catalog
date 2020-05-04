<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../controller/Main.php';

/**
 * Class Product
 */
class Product extends Main
{
    /**
     * @param string $action
     *
     * @return string
     */
    public function actions($action)
    {
        switch ($action) {
            case 'get-products-by-param':
                $this->getProductsByParam();
                break;
            case 'get-product-by-id':
                $this->getProductsById();
                break;
            default:
                $this->error();
                break;
        }
    }

    /**
     * @return Json
     */
    public function getProductsByParam()
    {
        $categoryId = $_POST['category_id'] ? (int)$_POST['category_id'] : false;
        $sortId = $_POST['sort_id'] ? (int)$_POST['sort_id'] : false;
        $db = new Database();
        $data['products'] = $db->getProductsByParams($categoryId, $sortId);
        $html = $this->template('../view/_part/product-table.php', ['data' => $data]);
        $result = [
            'success' => true,
            'message' => 'ok',
            'data' => $html,
        ];
        echo json_encode($result);
    }

    /**
     * @return Json
     */
    public function getProductsById()
    {
        $productId = $_POST['product_id'] ? (int)$_POST['product_id'] : false;
        if ($productId) {
            $db = new Database();
            $productData = $db->getProductsById($productId);
            $html = $this->template('../view/_part/product-item.php', ['productData' => $productData]);
            $result = [
                'success' => true,
                'message' => 'ok',
                'data' => $html,
            ];
        }else {
            $result = [
                'success' => false,
                'message' => 'Missing params',
            ];
        }

        echo json_encode($result);
    }

    /**
     * @return Json
     */
    public function error()
    {
        $result = [
            'success' => false,
            'message' => 'Missing params',
        ];
        echo json_encode($result);
    }

}

$action = $_POST['action'];
$product = new Product();
$product->actions($action);