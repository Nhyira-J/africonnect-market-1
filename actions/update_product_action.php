<?php
include("../controllers/product_controller.php");

header('Content-Type: application/json');

if(isset($_POST['product_id'])){
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $delivery_time = $_POST['delivery_time'];
    $stock_status = $_POST['stock_status']; // Assuming this field exists in form
    
    // Default values for optional fields
    $brand = NULL; 
    
    // Get existing product to keep old image if no new one is uploaded
    $existing_product = view_one_product_ctr($id);
    $image_url = $existing_product['image_url'];

    // Handle Image Upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $target_dir = "../uploads/products/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            $image_url = $target_file;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
            exit();
        }
    }

    $result = update_product_ctr($id, $name, $description, $price, $quantity, $category, $brand, $delivery_time, $image_url, $stock_status);

    if($result){
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update product']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
