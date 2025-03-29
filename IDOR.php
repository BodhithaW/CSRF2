<?php
session_start();

// Simulated database connection
$users = [
    1 => ['email' => 'user1@example.com'],
    2 => ['email' => 'user2@example.com']
];

// Simulate user login (User 1 is logged in)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
}

// Vulnerable Email Change Script (IDOR)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['user_id'])) {
    $new_email = $_POST['email'];
    $target_user_id = $_POST['user_id']; // Attacker can change this

    // ⚠️ No authorization check! A logged-in user can change anyone's email
    $users[$target_user_id]['email'] = $new_email;
    
    echo "User $target_user_id email updated to: " . htmlspecialchars($new_email);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IDOR Vulnerability Demo</title>
</head>
<body>
    <h2>Change Email (Vulnerable to IDOR)</h2>
    <form action="" method="POST">
        <label for="email">New Email:</label>
        <input type="email" name="email" required><br>
        <label for="user_id">Target User ID:</label>
        <input type="number" name="user_id" required> <!-- User ID can be manipulated -->
        <button type="submit">Change Email</button>
    </form>
</body>
</html>
