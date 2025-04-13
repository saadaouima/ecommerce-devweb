<?php
session_start();

class Cart {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addProduct($productId, $quantity = 1) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += (int) $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'product_id' => $productId,
                'quantity'   => $quantity
            ];
        }
    }

    public function removeProduct($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function updateQuantity($productId, $quantity) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }

    public function getCartItems() {
        return $_SESSION['cart'];
    }

    
    

    public function getTotalQuantity() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
    }
}
?>
