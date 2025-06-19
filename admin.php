<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    die('Access denied. You must be logged in as admin.');
}

$mysqli = new mysqli("127.0.0.1", "root", "", "phone_store");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $mysqli->real_escape_string($_POST["name"]);
    $description = $mysqli->real_escape_string($_POST["description"]);
    $price = floatval($_POST["price"]);

    $stmt = $mysqli->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Product</h2>
    <form method="post">
        <div class="form-group">
            <label>Product Name</label>
            <input name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>Price ($)</label>
            <input name="price" type="number" step="0.01" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
    <a href="index.php" class="btn btn-secondary mt-3">Back to Store</a>
</div>
</body>
</html>