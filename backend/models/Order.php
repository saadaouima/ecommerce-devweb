<?php
class Order {
    private mysqli $db; // ✅ Declare $db explicitly to avoid dynamic property issues

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "eshop");

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    // Create new order and return its ID
    public function createOrder($userId, $total, $paymentMethod) {
        $userId        = (int)$userId;
        $total         = (float)$total;
        $paymentMethod = $this->db->real_escape_string($paymentMethod);
        $orderDate     = date('Y-m-d H:i:s');

        $sql = "INSERT INTO orders (user_id, total_amount, payment_method, order_date)
                VALUES ('$userId', '$total', '$paymentMethod', '$orderDate')";

        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        } else {
            return false;
        }
    }

    // Add items to order_items table
    public function addOrderItem($orderId, $productId, $quantity, $price) {
        $orderId   = (int)$orderId;
        $productId = (string)$productId;
        $quantity  = (int)$quantity;
        $price     = (float)$price;

        $sql = "INSERT INTO cart (order_id, product_id, quantity, price)
                VALUES ('$orderId', '$productId', '$quantity', '$price')";

        return $this->db->query($sql);
    }

    // Get order details by order ID (with items)
    public function getOrderById($orderId) {
        $orderId = (int)$orderId;

        $sql = "SELECT * FROM orders WHERE id = '$orderId'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function getOrderItems($orderId) {
        $orderId = (int)$orderId;

        $sql = "SELECT oi.*, p.name
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = '$orderId'";

        $result = $this->db->query($sql);
        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }
}
?>
