<?php
session_start();
include("../controllers/cart_controller.php");

if(isset($_GET['id'])){
    $item_id = $_GET['id'];
    remove_from_cart_ctr($item_id);
    header("Location: ../view/cart.php");
}
?>
