<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "root", "", "phone_store");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $mysqli->real_escape_string($_POST["username"]);
    $result = $mysqli->query("SELECT * FROM users WHERE username = '$username'");
    $user = $result->fetch_assoc();
    if (password_verify($_POST["password"], $user["password"])) {
        $_SESSION["username"] = $username;
        header("Location: index.php");
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="form-group">
            <label>Username</label>
            <input name="username" class="form-control">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input name="password" type="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>