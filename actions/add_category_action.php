<?php
session_start();
header('Content-Type: application/json');
include("../controllers/category_controller.php");

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
$cat_name = isset($data['name']) ? trim($data['name']) : '';

if(empty($cat_name)){
    echo json_encode(['success' => false, 'message' => 'Category name is required']);
    exit;
}

// Call the controller function
// Call the controller function
// Passing empty string for description as it's not in the form
$result = add_category_ctr($cat_name, 'Standard Category');
if($result){
    echo json_encode(['success' => true, 'message' => 'Category added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add category']);
}
?>