<?php
include("../controllers/product_controller.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $product = view_one_product_ctr($id);
    
    if($product){
        echo json_encode(['status' => 'success', 'data' => $product]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
}
?>
