<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
include("../controllers/category_controller.php");

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
$cat_id = isset($data['id']) ? trim($data['id']) : '';
$new_name = isset($data['new_name']) ? trim($data['new_name']) : '';

if (empty($cat_id) || empty($new_name)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Call the controller function
// Fetch existing category to get description (since we only edit name here)
$existing_cat = get_category_ctr($cat_id);
$description = $existing_cat ? $existing_cat['description'] : '';

$result = update_category_ctr($cat_id, $new_name, $description);
if ($result) {
    echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update category']);
}
exit; // 🚨 important to stop execution

?>