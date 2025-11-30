<?php
error_reporting(E_ALL);       // Report all errors
ini_set('display_errors', 1); // Show errors in the browser
ini_set('display_startup_errors', 1);

session_start();
include("../controllers/product_controller.php");
// include("../settings/db_class.php"); // Already included in product_controller.php

if(isset($_POST['add_product'])){
    $user_id = $_SESSION['user_id'];
    
    // Get artisan_id
    if(isset($_SESSION['artisan_id'])){
        $artisan_id = $_SESSION['artisan_id'];
    } else {
        $db = new db_connection();
        $conn = $db->db_conn();
        $sql = "SELECT artisan_id FROM artisans WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if($result && mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $artisan_id = $row['artisan_id'];
            // Update session for future use
            $_SESSION['artisan_id'] = $artisan_id;
        } else {
            // Artisan profile not found
            header("Location: ../artisan/product.php?error=no_artisan_profile");
            exit();
        }
    }

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $category = $_POST['category'];
    $description = $_POST['description'];
    $delivery_time = $_POST['delivery_time'];
    $brand_id = NULL; // Optional
    $stock_status = 'available';

    // Image Upload Logic
    $image_url = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $target_dir = "../uploads/products/";
        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        // Allow certain file formats
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        if(in_array(strtolower($file_extension), $allowed_types)){
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                $image_url = $target_file;
            } else {
                header("Location: ../artisan/product.php?error=upload_failed");
                exit();
            }
        } else {
            header("Location: ../artisan/product.php?error=invalid_file_type");
            exit();
        }
    }

    $result = add_product_ctr($artisan_id, $name, $description, $price, $quantity, $category, $brand_id, $delivery_time, $image_url, $stock_status);

    if($result){
        header("Location: ../artisan/product.php?success=added");
    } else {
        header("Location: ../artisan/product.php?error=failed");
    }
}
?>
