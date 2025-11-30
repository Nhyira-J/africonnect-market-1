<?php
session_start();
require_once("../controllers/cart_controller.php");

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: ../view/login.php");
    exit();
}

if(isset($_POST['pay'])){
    $email = $_POST['email'];
    $amount = get_cart_total_ctr($_SESSION['customer_id']);
    
    // Ensure amount is valid
    if($amount <= 0){
        header("Location: ../view/cart.php");
        exit();
    }

    // Paystack expects amount in pesewas (multiply by 100)
    $amount_kobo = $amount * 100;
    
    $url = "https://api.paystack.co/transaction/initialize";
    $fields = [
        'email' => $email,
        'amount' => $amount_kobo,
        'callback_url' => "http://169.239.251.102:442/~jemima.nhyira/actions/verify_payment.php",
        'metadata' => [
            'customer_id' => $_SESSION['customer_id'],
            'user_id' => $_SESSION['user_id']
        ]
    ];

    $fields_string = http_build_query($fields);

    // Open connection
    $ch = curl_init();
    
    // Set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer sk_test_6c056b0fdd517a10f835a4f48dc65b89aad94b95", // REPLACE WITH YOUR TEST SECRET KEY
        "Cache-Control: no-cache",
    ));
    
    // So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    // Execute post
    $result = curl_exec($ch);
    
    if ($result === false) {
        die('Curl error: ' . curl_error($ch));
    }
    
    $response = json_decode($result, true);
    
    // Close connection
    curl_close($ch);
    
    if($response['status']){
        // Redirect to Paystack payment page
        $authorization_url = $response['data']['authorization_url'];
        header("Location: " . $authorization_url);
        exit();
    } else {
        // Handle error
        die("Payment initialization failed: " . $response['message']);
    }
} else {
    header("Location: ../view/checkout.php");
    exit();
}
?>
