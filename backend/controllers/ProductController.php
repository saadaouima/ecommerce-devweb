<?php
include_once dirname(__DIR__) . '/models/Product.php'; // Fix the path dynamically

class ProductController {
    private $productModel;
    public function getAllProducts() {
        $productModel = new Product();
        return $productModel->fetchAllProducts(); // Ensure this method exists in Product.php
    }
}
?>


class ProductController {

    // Add a new product
    public function addProduct($name, $price, $description, $manufacturer, $category, $conn) {
        $product = new Product($name, $price, $description, $manufacturer, $category);
        $product->save($conn);  // Save the product to the database
        echo "Product added successfully!<br>";
    }

    // Edit an existing product by ID
    public function editProduct($id, $name, $price, $description, $manufacturer, $category, $conn) {
        $product = Product::getById($conn, $id);
        if ($product) {
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $product->setManufacturer($manufacturer);
            $product->setCategory($category);
            $product->save($conn);  // Update the product in the database
            echo "Product updated successfully!<br>";
        } else {
            echo "Product not found!<br>";
        }
    }

    // Delete a product by ID
    public function deleteProduct($id, $conn) {
        $product = Product::getById($conn, $id);
        if ($product) {
            $product->delete($conn);  // Delete the product from the database
            echo "Product deleted successfully!<br>";
        } else {
            echo "Product not found!<br>";
        }
    }

    // Get a product by ID
    public function getProductById($id, $conn) {
        $product = Product::getById($conn, $id);
        if ($product) {
            echo "Product ID: " . $product->getId() . "<br>";
            echo "Product Name: " . $product->getName() . "<br>";
            echo "Price: $" . $product->getPrice() . "<br>";
            echo "Description: " . $product->getDescription() . "<br>";
            echo "Manufacturer: " . $product->getManufacturer() . "<br>";
            echo "Category: " . $product->getCategory() . "<br>";
        } else {
            echo "Product not found!<br>";
        }
    }

    // Get all products
    public function getAllProducts($conn) {
        $products = Product::getAll($conn);
        if (!empty($products)) {
            foreach ($products as $product) {
                echo "Product ID: " . $product->getId() . " | " . 
                     "Product Name: " . $product->getName() . " | " . 
                     "Price: $" . $product->getPrice() . "<br>";
            }
        } else {
            echo "No products found!<br>";
        }
    }
}
?>
