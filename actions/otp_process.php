<?php
session_start();
include("../controllers/customer_controller.php");
include("../functions/send_mail.php");

if(isset($_POST['verify_otp'])){
    $otp = $_POST['otp'];
    $user_id = $_SESSION['temp_user_id'];
    $email = $_SESSION['temp_email'];

    $customer = new customer_class();
    $result = $customer->verify_otp($user_id, $otp);

    if($result){
        // Clear temp session
        unset($_SESSION['temp_user_id']);
        unset($_SESSION['temp_email']);

        // Fetch user details to check role
        $user = $customer->get_customer_details($user_id);
        
        if($user['user_type'] == 'artisan'){
            // Send "Awaiting Verification" email for artisans
            $subject = "Registration Successful - Awaiting Verification";
            $body = "Hello " . $user['full_name'] . ",\n\nYour email has been verified successfully. Your account is now pending admin verification. You will be notified once your account is approved.\n\nRegards,\nAfriConnect Team";
            send_general_email($email, $subject, $body);
        } else {
            // Send "Welcome" email for customers
            $subject = "Welcome to AfriConnect";
            $body = "Hello " . $user['full_name'] . ",\n\nYour email has been verified successfully. Welcome to AfriConnect! You can now log in and start shopping.\n\nRegards,\nAfriConnect Team";
            send_general_email($email, $subject, $body);
        }

        header("Location: ../view/login.php?success=verified");
    } else {
        header("Location: ../view/otp_verification.php?error=invalid");
    }
}
?>
