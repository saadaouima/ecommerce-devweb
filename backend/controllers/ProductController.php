<?php
include_once dirname(__DIR__) . '/models/Product.php'; // Fix the path dynamically

class ProductController {
    private $productModel;
    private mysqli $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'eshop');

        if ($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
    }
    public function getAllProducts() {
        $productModel = new Product();
        return $productModel->fetchAllProducts(); // Ensure this method exists in Product.php
    }

    public function getAllCategories(){
        $sql = "SELECT DISTINCT Category FROM products";
        $result = $this->db->query($sql);

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['Category']; // Only add the string value
        }

        return  $categories;

    }

    public function getAllCategoriesWithProductsCount(){
       $sql = "SELECT Category, COUNT(*) AS ProductCount FROM products GROUP BY Category";
       $result = $this->db->query($sql);

       $categoriesWithProductsCount = [];
       while ($row = $result->fetch_assoc()) {
        $categoriesWithProductsCount[] = $row;
    }
    return  $categoriesWithProductsCount;
    }

    public function getThreeRandomProducts(){
        $sql = "SELECT * FROM products LIMIT 3";
        $result = $this->db->query($sql);

        $threeRandomProducts = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['Id'];
    
                // Step 2: Fetch all images for this product
                $imgSql = "SELECT Id FROM images WHERE product_id = ?";
                $stmt = $this->db->prepare($imgSql);
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $imgResult = $stmt->get_result();
    
                $images = [];
                while ($imgRow = $imgResult->fetch_assoc()) {
                    $images[] = $imgRow['Id'];
                }
    
                // Step 3: Add images to product data
                $row['images'] = $images;
    
                $threeRandomProducts[] = $row;
            }
        }

        /*while ($row = $result->fetch_assoc()) {
            $threeRandomProducts[] = $row;
        }*/
        return   $threeRandomProducts;
    }
}
?>
