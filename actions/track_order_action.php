<?php
require_once("../controllers/order_controller.php");

header('Content-Type: application/json');

if(isset($_POST['invoice_no']) && isset($_POST['email'])){
    $invoice_no = $_POST['invoice_no'];
    $email = $_POST['email'];
    
    // We need a method to get order by invoice_no and verify email
    // Since we don't have a direct method, we'll fetch all orders and filter (not efficient but works for now)
    // OR better, add a specific method to order_class. Let's add a quick query here or add a method.
    // Adding a method is cleaner. But for speed, I'll use a direct query via db_connection if I can, 
    // or just add the method to order_class.php first.
    
    // Let's use the existing get_all_orders and filter, or add a new method.
    // Actually, I should add `get_order_by_invoice($invoice_no)` to order_class.php.
    // But I can't modify order_class.php in this step easily without another tool call.
    // I'll try to use what I have. `get_all_orders_ctr` returns everything.
    
    // Wait, I can just instantiate the class here if I include it.
    $db = new db_connection();
    $conn = $db->db_conn();
    
    $invoice_no = mysqli_real_escape_string($conn, $invoice_no);
    $email = mysqli_real_escape_string($conn, $email);
    
    $sql = "SELECT o.*, u.full_name, u.email 
            FROM orders o 
            JOIN customers c ON o.customer_id = c.customer_id 
            JOIN users u ON c.user_id = u.user_id 
            WHERE o.invoice_no = '$invoice_no' AND u.email = '$email'";
            
    $result = mysqli_query($conn, $sql);
    
    if($row = mysqli_fetch_assoc($result)){
        echo json_encode(['status' => 'success', 'order' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order not found or email does not match.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
