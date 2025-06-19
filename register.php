<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "phone_store");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $mysqli->real_escape_string($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $mysqli->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Register</h2>
    <form method="post">
        <div class="form-group">
            <label>Username</label>
            <input name="username" class="form-control">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input name="password" type="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
</body>
</html>