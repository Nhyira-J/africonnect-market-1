<?php
include("../controllers/order_controller.php");

header('Content-Type: application/json');

if(isset($_POST['order_id']) && isset($_POST['status'])){
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    $result = update_order_status_ctr($order_id, $status);

    if($result){
        // Fetch order details for email
        $order = get_order_ctr($order_id);
        if($order){
            $to = $order['email'];
            $subject = "Order Status Update - #" . $order['invoice_no'];
            $message = "Dear " . $order['customer_name'] . ",\n\n";
            $message .= "The status of your order #" . $order['invoice_no'] . " has been updated to: " . ucfirst($status) . ".\n\n";
            
            if($status == 'delivered'){
                $message .= "We hope you enjoy your purchase! Please take a moment to confirm receipt and leave a review for the artisan.\n";
                $message .= "You can view your order details here: http://localhost/afriConnectapp/view/orders.php\n\n";
            }
            
            $message .= "Thank you for shopping with AfriConnect!\n";

            // Send email
            require_once("../functions/send_mail.php");
            send_general_email($to, $subject, $message);
        }

        echo json_encode(['status' => 'success', 'message' => 'Order status updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update order status']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
