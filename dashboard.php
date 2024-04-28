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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($csrf_protection) {
        // CSRF Protection Check
        if (!isset($_POST['csrf_token']) || !hash_equals($_POST['csrf_token'], $_SESSION['csrf_token'])) {
            die('CSRF token validation failed');
        }
    }

    $new_email = $conn->real_escape_string($_POST['email']);
    $conn->query("UPDATE users SET email='{$new_email}' WHERE username='$username'");
    // Redirect to the same page to avoid re-submitting the form on refresh
    header("Location: dashboard.php");
    exit;
}

// Fetch the current email from the database every time the page is loaded
$result = $conn->query("SELECT email FROM users WHERE username='$username'");
$row = $result->fetch_assoc();
$current_email = $row['email'];

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
