<?php
class Product {
    private mysqli $db; // ✅ Declare $db explicitly to avoid dynamic property issues

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "eshop");

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function fetchAllProducts(): array { // ✅ Return type hinting for strict PHP versions
        $sql = "SELECT * FROM products";
        $result = $this->db->query($sql);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function __destruct() { // ✅ Close the DB connection properly
        $this->db->close();
    }
}
?>
