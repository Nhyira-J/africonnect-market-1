<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

require_once '../settings/db_class.php';

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['user_id']) || !isset($input['full_name']) || !isset($input['email']) || !isset($input['user_type'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

$userId = intval($input['user_id']);
$fullName = trim($input['full_name']);
$email = trim($input['email']);
$userType = trim($input['user_type']);

// Validate inputs
if (empty($fullName) || !preg_match('/^[a-zA-Z\s]+$/', $fullName)) {
    echo json_encode(['success' => false, 'message' => 'Invalid full name']);
    exit();
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit();
}

$allowedTypes = ['customer', 'artisan', 'admin'];
if (!in_array($userType, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid user type']);
    exit();
}

// Prevent admin from changing their own account to prevent lockout
if ($userId == $_SESSION['user_id'] && $userType != 'admin') {
    echo json_encode(['success' => false, 'message' => 'You cannot change your own admin role']);
    exit();
}

// Connect to database
$db = new db_connection();
$conn = $db->db_conn();

// Check if email is already taken by another user
$checkEmailSql = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
$stmt = $conn->prepare($checkEmailSql);
$stmt->bind_param("si", $email, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already in use by another user']);
    exit();
}

// Update user
$updateSql = "UPDATE users SET full_name = ?, email = ?, user_type = ? WHERE user_id = ?";
$stmt = $conn->prepare($updateSql);
$stmt->bind_param("sssi", $fullName, $email, $userType, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
