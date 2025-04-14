<?php
require_once dirname(__DIR__) . '/models/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function placeOrder($userId, $cartItems, $paymentMethod) {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['Price'] * $item['Quantity'];
        }

        // Create order
        $orderId = $this->orderModel->createOrder($userId, $total, $paymentMethod);

        if ($orderId) {
            foreach ($cartItems as $item) {
                $this->orderModel->addOrderItem(
                    $orderId,
                    $item['Id'],
                    $item['Quantity'],
                    $item['Price']
                );
            }

            // Empty session cart after order
            unset($_SESSION['cart']);

            return $orderId;
        } else {
            return false;
        }
    }

    public function viewOrder($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $items = $this->orderModel->getOrderItems($orderId);

        return [
            'order' => $order,
            'items' => $items
        ];
    }
}
?>
