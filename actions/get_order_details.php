<?php
session_start();
include("../controllers/order_controller.php");

header('Content-Type: application/json');

if(isset($_GET['order_id']) && isset($_SESSION['artisan_id'])){
    $order_id = $_GET['order_id'];
    $artisan_id = $_SESSION['artisan_id'];
    
    // Get general order info
    $order = get_order_ctr($order_id);
    
    // Get specific products for this artisan in this order
    $products = get_order_details_by_artisan_ctr($order_id, $artisan_id);

    if($order && $products){
        echo json_encode([
            'status' => 'success', 
            'order' => $order, 
            'products' => $products
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order details not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
