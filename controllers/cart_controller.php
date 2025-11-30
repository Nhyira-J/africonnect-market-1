<?php
include("../classes/cart_class.php");

function add_to_cart_ctr($customer_id, $product_id, $quantity){
    $cart = new cart_class();
    return $cart->add_to_cart($customer_id, $product_id, $quantity);
}

function view_cart_ctr($customer_id){
    $cart = new cart_class();
    return $cart->view_cart($customer_id);
}

function update_cart_quantity_ctr($item_id, $quantity){
    $cart = new cart_class();
    return $cart->update_cart_quantity($item_id, $quantity);
}

function remove_from_cart_ctr($item_id){
    $cart = new cart_class();
    return $cart->remove_from_cart($item_id);
}

function get_cart_total_ctr($customer_id){
    $cart = new cart_class();
    return $cart->get_cart_total($customer_id);
}

function clear_cart_ctr($customer_id){
    $cart = new cart_class();
    return $cart->clear_cart($customer_id);
}
?>
