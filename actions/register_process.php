<?php
session_start();
include("../controllers/customer_controller.php");

if(isset($_POST['register'])){
    $full_name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    
    // Default to customer if role is not set (since dropdown was removed)
    $role = isset($_POST['role']) ? $_POST['role'] : 'customer';
    
    $address = ""; 

    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : null;
    $bio = isset($_POST['bio']) ? $_POST['bio'] : null;

    // Simple validation
    if(empty($full_name) || empty($email) || empty($password) || empty($country) || empty($city) || empty($contact)){
        header("Location: ../view/register.php?error=empty_fields");
        exit();
    }

    $result = add_user_ctr($full_name, $email, $contact, $password, $address, $country, $city, $role, $business_name, $bio);

    if($result === "duplicate"){
        header("Location: ../view/register.php?error=email_taken");
    } elseif(is_array($result) && $result['status']){
        // Send OTP Email
        include("../functions/send_mail.php");
        $subject = "Verify Your Email - AfriConnect";
        $body = "Hello $full_name,\n\nYour OTP for email verification is: " . $result['otp_code'] . "\n\nThis code expires in 15 minutes.\n\nRegards,\nAfriConnect Team";
        send_general_email($email, $subject, $body);

        // Store user_id in session for OTP verification
        $_SESSION['temp_user_id'] = $result['user_id'];
        $_SESSION['temp_email'] = $email;
        
        header("Location: ../view/otp_verification.php");
    } else {
        header("Location: ../view/register.php?error=failed");
    }
}
?>
