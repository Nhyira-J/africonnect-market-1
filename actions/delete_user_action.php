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
if (!isset($input['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing user ID']);
    exit();
}

$userId = intval($input['user_id']);

// Prevent admin from deleting their own account
if ($userId == $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'You cannot delete your own account']);
    exit();
}

// Connect to database
$db = new db_connection();
$conn = $db->db_conn();

// Check if user exists
$checkSql = "SELECT user_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

// Delete user
$deleteSql = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete user: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
