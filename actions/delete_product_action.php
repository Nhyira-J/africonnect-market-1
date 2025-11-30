<?php
include("../controllers/product_controller.php");

header('Content-Type: application/json');

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $result = delete_product_ctr($id);

    if($result){
        echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete product']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
