<?php
require_once __DIR__ . '/../model/Database.php';

/**
 * Class Main
 */
class Main
{
    /**
     * Create tables if those not exist
     * @return action index
     */
    public function db()
    {
        $db = new Database();
        $product = $db->query('SHOW TABLES LIKE "product"');
        $category = $db->query('SHOW TABLES LIKE "category"');

        if (!$product->rowCount()) {
            $db->createTableProduct();
        }

        if (!$category->rowCount()) {
            $db->createTableCategory();
        }
        $this->index();
    }

    /**
     * show index page
     * @return string
     */
    public function index()
    {
        $data = [];
        $db = new Database();
        $data['sort_id'] = $_REQUEST['sort_id'] ? (int)$_REQUEST['sort_id'] : false;
        $data['category_id'] = $_REQUEST['category_id'] ? (int)$_REQUEST['category_id'] : false;
        $data['products'] = $db->getProductsByParams($data['category_id'], $data['sort_id']);
        $data['category'] = $db->getAllCategories();
        $html = $this->template('view/index.php', ['data' => $data]);
        echo $html;
    }

    /**
     * render template
     *
     * @param string $view
     * @param array  $data
     *
     * @return string
     */
    public function template($view, $data)
    {
        extract($data);
        ob_start();
        require $view;
        $output = ob_get_clean();

        return $output;
    }
}