<?php
session_start();
include 'db.php';

// CSRF Protection Toggle
$csrf_protection = false;  // Change to true to enable CSRF protection

if ($csrf_protection) {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrf_token = $_SESSION['csrf_token'];
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$result = $conn->query("SELECT email FROM users WHERE username='$username'");
$row = $result->fetch_assoc();
$current_email = $row['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($csrf_protection) {
        // CSRF Protection Check
        if (!isset($_POST['csrf_token']) || !hash_equals($_POST['csrf_token'], $_SESSION['csrf_token'])) {
            die('CSRF token validation failed');
        }
    }
    
    $new_email = $conn->real_escape_string($_POST['email']);
    $conn->query("UPDATE users SET email='{$new_email}' WHERE username='$username'");
    $message = "Email changed to: " . htmlspecialchars($new_email);
} else {
    $message = "Your current email is: " . htmlspecialchars($current_email);
}
?>
<html>
<head><title>Dashboard</title></head>
<body>
<h2>Dashboard</h2>
<p>You are logged in!</p>
<p><?php echo $message; ?></p>
<form method="POST" action="dashboard.php">
    <?php if ($csrf_protection) { ?>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <?php } ?>
    New Email: <input type="text" name="email"><br>
    <input type="submit" value="Change Email">
</form>
</body>
</html>
