<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    echo "Email changed to: " . htmlspecialchars($_POST['email']);
    // Here, you would typically save the email to a database or something similar.
}
?>
