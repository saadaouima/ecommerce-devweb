<?php
// index.php

// Include the controller
require_once '..\..\backend\controllers\ProductController.php';

// Instantiate the controller
$productController = new ProductController();

// Get all products using the controller
$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Product List</h1>

    <?php
    if (!empty($products)) {
        echo "<table>";
        echo "<tr><th>Product ID</th><th>Product Name</th><th>Price</th><th>Description</th><th>Manufacturer</th><th>Category</th></tr>";

        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product['Id'] . "</td>";
            echo "<td>" . $product['Name'] . "</td>";
            echo "<td>" . $product['Price'] . "</td>";
            echo "<td>" . $product['Details'] . "</td>";
            echo "<td>" . $product['Manufacturer_Name'] . "</td>";
            echo "<td>" . $product['Category'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No products found.";
    }
    ?>

</body>
</html>