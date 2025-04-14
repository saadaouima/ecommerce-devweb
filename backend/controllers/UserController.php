<?php
include_once dirname(__DIR__) . '/models/User.php';
include_once dirname(__DIR__) . '/controllers/OrderController.php';
include_once dirname(__DIR__) . '/controllers/CartController.php';

class UserController{
    public function __construct() {
       
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $data = [
        'first_name'  => $_POST['first_name'],
        'last_name'   => $_POST['last_name'],
        'address'     => $_POST['address'],
        'city'        => $_POST['city'],
        'governorate' => $_POST['governorate'],
        'postcode'    => $_POST['postcode'],
        'phone'       => $_POST['phone'],
        'email'       => $_POST['email'],
        'password'    => $_POST['password'],
    ];

    $userModel = new User();
    $createdUserId = $userModel->createUser($data);

    if ($createdUserId != false) {
        session_start();
         // Store user info in session
         $_SESSION['user'] = [
            'id'         => $createdUserId,
            'first_name' => $_POST['first_name'],
            'last_name'  => $_POST['last_name'],
            'email'      => $_POST['email']
        ];
       $orderController =new OrderController();
       $cartController =new CartController();
       $cartItems = $cartController->getCartItems();
       $orderController->placeOrder($createdUserId, $cartItems, 'Paypal' );
    } else {
        echo "Error: " ;
    }
}
?>
