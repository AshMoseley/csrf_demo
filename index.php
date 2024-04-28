<?php
session_start();
include 'db.php';  // Include the database connection

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    if ($result->num_rows == 1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<form method="POST" action="index.php">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
<?php if (!empty($login_error)) echo "<p>$login_error</p>"; ?>
</body>
</html>
