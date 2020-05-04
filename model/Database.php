<?php
require_once __DIR__ . '/../model/Database.php';
/**
 * Class Database
 */
class Database
{
    const DB_HOST = '127.0.0.1';
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_NAME = 'test_mag';
    const CHARSET = 'utf8';

    const SORT_ALPHABETICAL_UP = 1;
    const SORT_ALPHABETICAL_DOWN = 2;
    const SORT_DATE_CREATED_UP = 3;
    const SORT_DATE_CREATED_DOWN = 4;
    const SORT_PRICE_UP = 5;
    const SORT_PRICE_DOWN = 6;

    protected static $instance = null;
    static private $db;

    public function __construct()
    {
        if (self::$instance === null) {
            try {
                self::$db = new PDO(
                    'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
                    self::DB_USER,
                    self::DB_PASSWORD,
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . self::CHARSET,
                    ]
                );
            }catch (PDOException $e) {
                throw new Exception ($e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * @param string $query
     * @return mixed
     */
    static public function exec($query)
    {
        return self::$db->exec($query);
    }

    /**
     * @param string $query
     * @param array $args
     * @return array
     * @throws
     */
    public static function getValue($query, $args = [])
    {
        $result = self::getRow($query, $args);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return $result;
    }

    /**
     * @param string $query
     * @param array $args
     * @return array
     * @throws
     */
    public static function getRow($query, $args = [])
    {
        return self::run($query, $args)->fetch();
    }

    /**
     * @param string $query
     * @param array $args
     * @return mixed
     * @throws
     */
    public static function run($query, $args = [])
    {
        try {
            if (!$args) {
                return self::query($query);
            }
            $stmt = self::prepare($query);
            $stmt->execute($args);

            return $stmt;
        }catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $stmt
     * @return mixed
     * @throws
     */
    public static function query($stmt)
    {
        return self::$db->query($stmt);
    }

    /**
     * @param string $stmt
     * @return mixed
     * @throws
     */
    public static function prepare($stmt)
    {
        return self::$db->prepare($stmt);
    }

    /**
     * Creating table Product with test products
     */
    public function createTableProduct()
    {
        self::query("CREATE TABLE product (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(64) NOT NULL,
            `price` INT(12) NOT NULL,
            `dt_create` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `dt_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `category_id` INT NOT NULL, PRIMARY KEY (`id`)
        )");
        self::query('ALTER TABLE `product` ADD KEY `category_id` (`category_id`);');
        self::query('INSERT INTO `product`(`name`,`price`,`dt_create`,`category_id`) VALUES
            ("Телефон", 100, "2020-02-15 01:12:00", 1),
            ("Машина", 110, "2020-02-11 10:02:00", 1),
            ("Корм", 120, "2020-02-10 04:21:00", 2),
            ("Ноутбук", 130, "2020-02-14 11:15:00", 2),
            ("ПК", 140, "2020-02-17 01:21:00", 3),
            ("Ковер", 150, "2020-02-19 02:20:00", 3),
            ("Наушники", 160, "2020-02-22 05:10:00", 4),
            ("Кофе", 170, "2020-02-23 01:00:00", 4),
            ("Шаурма", 180, "2020-02-24 08:20:00", 5),
            ("Кошелек",190, "2020-02-25 08:25:00", 5),
            ("Коробка", 200, "2020-02-26 05:40:00", 1),
            ("Мышка", 210, "2020-02-27 03:30:00", 2),
            ("Клавиатура", 200, "2020-02-01 09:10:00", 3),
            ("Игрушка", 230, "2020-02-02 11:25:00", 4),
            ("Заколка", 240, "2020-02-03 01:18:00", 5)
            ');
    }

    /**
     * Creating table Category with test categories
     */
    public function createTableCategory()
    {
        self::query("CREATE TABLE category (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(64) NOT NULL , PRIMARY KEY (`id`)
            )");
        self::query('INSERT INTO `category`(`name`) VALUES ("Категория 1"),("Категория 2"),("Категория 3"),("Категория 4"),("Категория 5")');
        self::query('ALTER TABLE `product` ADD CONSTRAINT `fk_ProductCategory` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`); COMMIT;');
    }

    /**
     * return array
     */
    public function getAllCategories()
    {
        return self::getRows('SELECT `id`,`name` FROM category');
    }

    /**
     * @param string $query
     * @param array $args
     * @return mixed
     * @throws
     */
    public static function getRows($query, $args = [])
    {
        return self::run($query, $args)->fetchAll();
    }

    /**
     * @param int|boolean $categoryId
     * @param int|boolean $sortId
     * @return mixed
     * @throws
     */
    public function getProductsByParams($categoryId = false, $sortId = false)
    {
        $sql = 'SELECT `id`,`name`,`price`,`dt_create` FROM product';
        if ($categoryId) {
            $sql .= ' WHERE category_id = "' . $categoryId . '"';
        }
        if ($sortId) {
            switch ($sortId) {
                case static::SORT_ALPHABETICAL_UP;
                    $sql .= ' ORDER BY name ASC';
                    break;
                case static::SORT_ALPHABETICAL_DOWN;
                    $sql .= ' ORDER BY name DESC';
                    break;
                case static::SORT_DATE_CREATED_UP;
                    $sql .= ' ORDER BY dt_create ASC';
                    break;
                case static::SORT_DATE_CREATED_DOWN;
                    $sql .= ' ORDER BY dt_create DESC';
                    break;
                case static::SORT_PRICE_UP;
                    $sql .= ' ORDER BY price ASC';
                    break;
                case static::SORT_PRICE_DOWN:
                    $sql .= ' ORDER BY price DESC';
                    break;
            }
        }

        return self::getRows($sql);
    }

    /**
     * @param int $productId
     * @return array|null
     * @throws
     */
    public function getProductsById($productId)
    {
        $sql = 'SELECT `id`,`name`,`price`,`dt_create` FROM product WHERE id = "' . $productId . '"';

        return self::getRow($sql);
    }
}

