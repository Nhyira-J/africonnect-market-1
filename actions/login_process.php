<?php
session_start();
include("../controllers/customer_controller.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        header("Location: ../view/login.php?error=empty_fields");
        exit();
    }

    $result = login_user_ctr($email, $password);

    if(is_array($result) && $result['status'] === 'success'){
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_role'] = $result['user_type'];
        $_SESSION['user_name'] = $result['full_name'];

        if(isset($result['customer_id'])) $_SESSION['customer_id'] = $result['customer_id'];
        if(isset($result['artisan_id'])) $_SESSION['artisan_id'] = $result['artisan_id'];

        // Redirect based on role
        if($result['user_type'] == 'customer'){
            header("Location: ../view/shop.php");
        } elseif($result['user_type'] == 'artisan'){
            header("Location: ../artisan/dashboard.php");
        } elseif($result['user_type'] == 'admin'){
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../index.php");
        }
    } elseif($result === "unverified_email"){
        header("Location: ../view/login.php?error=unverified_email");
    } else {
        header("Location: ../view/login.php?error=invalid_credentials");
    }
}
?>
