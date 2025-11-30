<?php
//connect to the user account class
include("../classes/customer_class.php");

function add_user_ctr($full_name, $email, $phone, $password, $address, $country, $city, $role, $business_name = null, $bio = null){
	$adduser=new customer_class();
	return $adduser->add_user($full_name, $email, $phone, $password, $address, $country, $city, $role, $business_name, $bio);
}

function login_user_ctr($email, $password) {
	$loginUser = new customer_class();
	return $loginUser->login_user($email, $password);
}

function get_customer_details_ctr($user_id){
    $customer = new customer_class();
    return $customer->get_customer_details($user_id);
}

function get_customer_by_id_ctr($customer_id){
    $customer = new customer_class();
    return $customer->get_customer_by_id($customer_id);
}

function get_artisan_details_ctr($user_id){
    $customer = new customer_class();
    return $customer->get_artisan_details($user_id);
}

function update_artisan_profile_ctr($user_id, $business_name, $bio, $phone, $address){
    $customer = new customer_class();
    return $customer->update_artisan_profile($user_id, $business_name, $bio, $phone, $address);
}

function get_all_users_ctr(){
    $customer = new customer_class();
    return $customer->get_all_users();
}

function get_recent_users_ctr(){
    $customer = new customer_class();
    return $customer->get_recent_users();
}

function get_unverified_artisans_ctr(){
    $customer = new customer_class();
    return $customer->get_unverified_artisans();
}

function verify_artisan_ctr($artisan_id){
    $customer = new customer_class();
    return $customer->verify_artisan($artisan_id);
}
?>