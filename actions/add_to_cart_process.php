<?php
session_start();
include("../controllers/cart_controller.php");

if(isset($_GET['id'])){
    $product_id = $_GET['id'];
    
    if(!isset($_SESSION['user_id'])){
        header("Location: ../view/login.php?error=login_required");
        exit();
    }
    
    // If customer_id is set, use it. 
    // If an artisan or admin tries to buy, we might need to handle that.
    // For now, let's assume only customers can buy, or we auto-create a cart for any user.
    // But our cart table links to customer_id.
    // So if user is artisan, they can't buy unless we treat them as customer too.
    // For simplicity, restrict to customers.
    
    if(isset($_SESSION['customer_id'])){
        $customer_id = $_SESSION['customer_id'];
        $quantity = 1; 
        $result = add_to_cart_ctr($customer_id, $product_id, $quantity);

        if($result){
            header("Location: ../view/cart.php");
        } else {
            header("Location: ../index.php?error=failed_to_add");
        }
    } else {
        // Redirect with message that only customers can shop
        header("Location: ../index.php?error=role_restriction");
    }
}
?>
