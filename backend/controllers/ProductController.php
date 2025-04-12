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
                $stmt->bind_param("s", $productId);
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
        return   $threeRandomProducts;
    }

    public function getProductById($id) {
        $sql = "SELECT p.*,  ROUND(IFNULL(AVG(r.rating), 0)) AS rating, COUNT(r.review_id) AS total_reviews FROM  products p LEFT JOIN reviews r ON p.id = r.product_id WHERE Id = ? GROUP BY p.id";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
       
        $imgSql = "SELECT Id FROM images WHERE product_id = ?";
        $stmt = $this->db->prepare($imgSql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $imgResult = $stmt->get_result();

        $images = [];
        while ($imgRow = $imgResult->fetch_assoc()) {
            $images[] = $imgRow['Id'];
        }

        // Step 3: Add images to product data
        $result ['images'] = $images;

        $reviewSql = "SELECT * FROM reviews WHERE product_id = ?";
        $stmt = $this->db->prepare($reviewSql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $reviewResult = $stmt->get_result();
        $reviewsArray = [];
        if ($reviewResult) {
            while ($row = $reviewResult->fetch_assoc()) {
                $reviewsArray[] = $row;
            }
        }
    
        $result['reviews'] = $reviewsArray;

      
        return  $result ?: null;
        
    }

    public function getProductsByCategory($category){
        $sql = "SELECT p.*, ROUND(IFNULL(AVG(r.rating), 0)) AS rating FROM products p LEFT JOIN reviews r ON p.id = r.product_id WHERE Category = ? GROUP BY p.Id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['Id'];
    
                // Step 2: Fetch all images for this product
                $imgSql = "SELECT Id FROM images WHERE product_id = ?";
                $stmt = $this->db->prepare($imgSql);
                $stmt->bind_param("s", $productId);
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
        return   $threeRandomProducts;

    }
}
?>
