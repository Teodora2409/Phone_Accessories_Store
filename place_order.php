<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$mysqli = new mysqli("127.0.0.1", "root", "", "phone_store");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (!isset($_SESSION['username'])) {
    die("You must be logged in to place an order.");
}

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $qty) {
        $stmt = $mysqli->prepare("INSERT INTO orders (username, product_id, quantity) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param("sii", $_SESSION['username'], $product_id, $qty);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    }
    $_SESSION['cart'] = [];
    $_SESSION['order_success'] = "Your order has been placed successfully!";
} else {
    $_SESSION['order_success'] = "Cart was empty. Nothing to order.";
}

header("Location: index.php");
exit;