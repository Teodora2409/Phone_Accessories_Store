<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "root", "", "phone_store");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        $_SESSION['cart'][$product_id]++;
    }
    header("Location: cart.php");
    exit;
}

$cart_items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $result = $mysqli->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $row['total'] = $row['quantity'] * $row['price'];
        $total += $row['total'];
        $cart_items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Your Cart</h2>
    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h4>Total: $<?= number_format($total, 2) ?></h4>
        <form method="post" action="place_order.php">
            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>