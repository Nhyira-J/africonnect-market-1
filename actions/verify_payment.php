<?php
session_start();
require_once("../controllers/cart_controller.php");
require_once("../controllers/order_controller.php");
require_once("../controllers/customer_controller.php");

if(isset($_GET['reference'])){
    $reference = $_GET['reference'];
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_test_6c056b0fdd517a10f835a4f48dc65b89aad94b95", // REPLACE WITH YOUR TEST SECRET KEY
            "Cache-Control: no-cache",
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $result = json_decode($response, true);
        
        if($result['status'] && $result['data']['status'] == 'success'){
            // Payment was successful
            
            // Get metadata
            $customer_id = $result['data']['metadata']['customer_id'];
            $amount_paid = $result['data']['amount'] / 100; // Convert back to main currency unit
            $currency = $result['data']['currency'];
            $invoice_no = "INV-" . mt_rand(1000, 9999) . "-" . time();
            
            // 1. Create Order
            // Check if customer exists
            $customer_check = get_customer_by_id_ctr($customer_id);
            if(!$customer_check){
                error_log("Verify Payment: Customer ID $customer_id not found in database. Payment received but order creation failed.");
                echo "Error: Customer record not found. Please contact support with reference: $reference";
                exit();
            }

            $order_id = add_order_ctr($customer_id, $invoice_no, $amount_paid, 'processing');
            
            if($order_id){
                // 2. Get Cart Items
                $cart_items = view_cart_ctr($customer_id);
                
                // 3. Add Order Details
                foreach($cart_items as $item){
                    add_order_details_ctr($order_id, $item['product_id'], $item['quantity'], $item['price']);
                }
                
                // 4. Add Payment Record
                add_payment_ctr($order_id, $amount_paid, $currency, 'completed');
                
                // 5. Clear Cart
                // We need a clear_cart_ctr function. Let's assume it exists or add it.
                // Checking cart_controller... we need to add clear_cart_ctr
                clear_cart_ctr($customer_id);
                
                // Send Confirmation Email
                $to = $result['data']['customer']['email']; // Paystack returns customer email
                error_log("Verify Payment: Attempting to send email to $to");
                require_once("../functions/send_mail.php");
                
                $customer_name = "Valued Customer";
                $invoice_data = [
                    'invoice_no' => $invoice_no,
                    'item_name' => "Order #" . $invoice_no,
                    'amount' => $amount_paid,
                    'tax' => 0,
                    'discount' => 0,
                    'total_amount' => $amount_paid,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'payment_method' => 'Paystack',
                    'transaction_id' => $reference,
                    'invoice_link' => '#', 
                    'dashboard_link' => 'http://localhost/afriConnectapp/view/track.php'
                ];
                
                $email_sent = send_invoice_email($to, $customer_name, $invoice_data);
                if($email_sent){
                    error_log("Verify Payment: Email sent successfully.");
                } else {
                    error_log("Verify Payment: Email failed to send.");
                }
                
                // Redirect to success page
                header("Location: ../view/payment_success.php?ord_id=" . $order_id . "&invoice_no=" . $invoice_no);
                exit();
            } else {
                echo "Failed to create order.";
            }
            
        } else {
            // Payment failed
            echo "Payment verification failed.";
        }
    }
} else {
    header("Location: ../view/checkout.php");
    exit();
}
?>
