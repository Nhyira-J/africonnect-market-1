<?php
require_once("../classes/order_class.php");

function add_order_ctr($customer_id, $invoice_no, $total_amount, $status){
    $order = new order_class();
    return $order->add_order($customer_id, $invoice_no, $total_amount, $status);
}

function add_order_details_ctr($order_id, $product_id, $quantity, $unit_price){
    $order = new order_class();
    return $order->add_order_details($order_id, $product_id, $quantity, $unit_price);
}

function add_payment_ctr($order_id, $amount, $currency, $status){
    $order = new order_class();
    return $order->add_payment($order_id, $amount, $currency, $status);
}

function get_order_ctr($order_id){
    $order = new order_class();
    return $order->get_order($order_id);
}

function get_all_orders_ctr(){
    $order = new order_class();
    return $order->get_all_orders();
}

function get_orders_by_artisan_ctr($artisan_id){
    $order = new order_class();
    return $order->get_orders_by_artisan($artisan_id);
}

function get_artisan_analytics_ctr($artisan_id){
    $order = new order_class();
    return $order->get_artisan_analytics($artisan_id);
}

function get_total_revenue_ctr(){
    $order = new order_class();
    return $order->get_total_revenue();
}

function update_order_status_ctr($order_id, $status){
    $order = new order_class();
    return $order->update_order_status($order_id, $status);
}

function get_order_details_by_artisan_ctr($order_id, $artisan_id){
    $order = new order_class();
    return $order->get_order_details_by_artisan($order_id, $artisan_id);
}
?>
