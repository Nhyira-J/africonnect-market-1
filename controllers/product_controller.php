<?php
require_once("../classes/product_class.php");

function add_product_ctr($artisan_id, $name, $description, $price, $quantity, $category_id, $brand_id, $estimated_delivery_time, $image_url, $stock_status){
    $addprod = new product_class();
    return $addprod->add_product($artisan_id, $name, $description, $price, $quantity, $category_id, $brand_id, $estimated_delivery_time, $image_url, $stock_status);
}

function view_all_products_ctr(){
    $viewprod = new product_class();
    return $viewprod->view_all_products();
}

function view_products_by_artisan_ctr($artisan_id){
    $viewprod = new product_class();
    return $viewprod->view_products_by_artisan($artisan_id);
}

function view_one_product_ctr($id){
    $viewprod = new product_class();
    return $viewprod->view_one_product($id);
}

function search_products_ctr($term){
    $searchprod = new product_class();
    return $searchprod->search_products($term);
}

function get_products_by_category_ctr($cat_id){
    $prod = new product_class();
    return $prod->get_products_by_category($cat_id);
}

function update_product_ctr($id, $name, $description, $price, $quantity, $category_id, $brand_id, $estimated_delivery_time, $image_url, $stock_status){
    $uprod = new product_class();
    return $uprod->update_product($id, $name, $description, $price, $quantity, $category_id, $brand_id, $estimated_delivery_time, $image_url, $stock_status);
}

function delete_product_ctr($id){
    $delprod = new product_class();
    return $delprod->delete_product($id);
}

function filter_products_ctr($category_id, $min_price, $max_price, $search_term){
    $filterprod = new product_class();
    return $filterprod->filter_products($category_id, $min_price, $max_price, $search_term);
}
?>
