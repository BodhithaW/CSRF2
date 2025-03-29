<?php
// Simulate a database of users
$users = [
    1 => ['username' => 'user1', 'email' => 'user1@example.com'],
    2 => ['username' => 'user2', 'email' => 'user2@example.com']
];

// Get the user ID from the request
$user_id = $_GET['user_id'];  // Vulnerable to manipulation by attacker

// Simulate fetching user data from a database
$user_data = $users[$user_id];

// Return the user data as JSON without validating or encoding input
header('Content-Type: application/json');
echo json_encode($user_data);
?>
