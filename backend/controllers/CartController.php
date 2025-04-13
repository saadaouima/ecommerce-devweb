<?php
include_once dirname(__DIR__) . '/models/Cart.php'; 

class CartController {
    private $cart;
    private mysqli $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'eshop');

        if ($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
        $this->cart = new Cart();
    }

    public function add($productId, $quantity = 1) {
        $this->cart->addProduct($productId, $quantity);
        return  $this->cart->getTotalQuantity();
    }

    public function remove($productId) {
        $this->cart->removeProduct($productId);
        header("Location: ../cart.php");
        exit;
    }

    public function update($productId, $quantity) {
        $this->cart->updateQuantity($productId, $quantity);
        header("Location: ../cart.php");
        exit;
    }

    public function clear() {
        $this->cart->clearCart();
        header("Location: ../cart.php");
        exit;
    }

    public function showCart() {
        return $this->cart->getCartItems();
    }

    public function getCartItems() {
        $cartItems = [];
    
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return $cartItems; // return empty array if cart is empty
        }
    
        $productIds = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        
        $sql = "SELECT p.*, ROUND(IFNULL(AVG(r.rating), 0)) AS rating, COUNT(r.review_id) AS total_reviews, ( SELECT img.Id FROM images img WHERE img.product_id = p.id ORDER BY img.id ASC LIMIT 1 ) AS first_image FROM products p LEFT JOIN reviews r ON p.id = r.product_id WHERE Id IN ($placeholders) GROUP BY p.id";
        $stmt = $this->db->prepare($sql);
    
        // Dynamically bind the parameters
        $types = str_repeat('s', count($productIds)); // assuming product IDs are integers
        $stmt->bind_param($types, ...$productIds);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($product = $result->fetch_assoc()) {
            $productId = $product['Id'];
            $product['Quantity'] = $_SESSION['cart'][$productId]['quantity'];
            $cartItems[] = $product;
        }
    
        return $cartItems;
    }
}
// If request is via POST and product_id is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $cartController = new CartController();
    $count = $cartController->add($_POST['product_id'], $_POST['quantity']);
    $cartController->showCart();
    echo $count;
}
?>
