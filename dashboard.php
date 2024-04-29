<?php
session_start();
include 'db.php';

// CSRF Protection Toggle
$csrf_protection = false;  // Change to true to enable CSRF protection

// CSRF token generation if not already done
if ($csrf_protection) {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    // Store the token in a variable for easy access
    $csrf_token = $_SESSION['csrf_token'];
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Check if the request method is POST, which indicates that the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($csrf_protection) {
        // Check if the submitted token matches the one in the session
        if (!isset($_POST['csrf_token']) || !hash_equals($_POST['csrf_token'], $_SESSION['csrf_token'])) {
            die('CSRF token validation failed');
        }
    }
    // Prevent SQL injection by escaping special characters
    $new_email = $conn->real_escape_string($_POST['email']);
    // Update user's email
    $conn->query("UPDATE users SET email='{$new_email}' WHERE username='$username'");
    header("Location: dashboard.php");
    exit;
}

// Get the current email
$result = $conn->query("SELECT email FROM users WHERE username='$username'");
$row = $result->fetch_assoc();

// Store the current email in a variable for easy access
$current_email = $row['email'];

// HTML for displaying page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Dashboard</h2>
            <p class="alert alert-success">You are logged in as <strong><?php echo htmlspecialchars($username); ?></strong></p>
            <p class="alert alert-info">Your current email is: <strong><?php echo htmlspecialchars($current_email); ?></strong></p>
            <form method="POST" action="dashboard.php">
                <div class="form-group">
                    <label for="email">New Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <?php if ($csrf_protection) { ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <?php } ?>
                <button type="submit" class="btn btn-primary">Change Email</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
