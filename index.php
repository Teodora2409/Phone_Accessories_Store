<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "root", "", "phone_store");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Phone Accessories Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Phone Accessories</h1>
        <?php if (isset($_SESSION['order_success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php
                echo $_SESSION['order_success'];
                unset($_SESSION['order_success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Logout</a>
            <?php if ($_SESSION['username'] === 'admin'): ?>
                | <a href="admin.php">Admin Panel</a>
            <?php endif; ?>
            | <a href="cart.php">Cart</a>
            </p>
        <?php else: ?>
            <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
        <?php endif; ?>

        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text"><strong>$<?php echo htmlspecialchars($row['price']); ?></strong></p>
                            <?php if (isset($_SESSION['username']) && $_SESSION['username'] !== 'admin'): ?>
                                <form method="post" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>