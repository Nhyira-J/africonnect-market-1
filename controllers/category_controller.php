<?php
//connect to the user account class
require_once("../classes/category_class.php");

function add_category_ctr($name, $description){
	$addcat=new category_class();
	return $addcat->add_category($name, $description);
}

function view_all_categories_ctr(){
    $viewcat=new category_class();
    return $viewcat->view_all_categories();
}

function get_category_ctr($id){
    $getcat=new category_class();
    return $getcat->get_category($id);
}

function update_category_ctr($id, $name, $description){
    $upcat=new category_class();
    return $upcat->update_category($id, $name, $description);
}

function delete_category_ctr($id){
    $delcat=new category_class();
    return $delcat->delete_category($id);
}
?>