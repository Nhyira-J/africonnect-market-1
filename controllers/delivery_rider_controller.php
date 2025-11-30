<?php
require_once("../classes/delivery_rider_class.php");

function add_rider_ctr($name, $email, $phone, $vehicle_type, $location, $status, $image_file){
    $rider_image = "";
    if(isset($image_file) && $image_file['error'] == 0){
        $target_dir = "../uploads/riders/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_extension = pathinfo($image_file["name"], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $new_file_name;
        
        if(move_uploaded_file($image_file["tmp_name"], $target_file)){
            $rider_image = $target_file;
        }
    }

    $rider = new delivery_rider_class();
    return $rider->add_rider($name, $email, $phone, $vehicle_type, $location, $status, $rider_image);
}

function view_all_riders_ctr(){
    $rider = new delivery_rider_class();
    return $rider->view_all_riders();
}

function view_one_rider_ctr($id){
    $rider = new delivery_rider_class();
    return $rider->view_one_rider($id);
}

function update_rider_ctr($id, $name, $email, $phone, $vehicle_type, $location, $status, $image_file){
    $rider_image = "";
    
    // If a new image is uploaded
    if(isset($image_file) && $image_file['error'] == 0){
        $target_dir = "../uploads/riders/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_extension = pathinfo($image_file["name"], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $new_file_name;
        
        if(move_uploaded_file($image_file["tmp_name"], $target_file)){
            $rider_image = $target_file;
        }
    } else {
        // Keep existing image if no new one uploaded
        // We need to fetch the existing image first
        $existing_rider = view_one_rider_ctr($id);
        $rider_image = $existing_rider['rider_image'];
    }

    $rider = new delivery_rider_class();
    return $rider->update_rider($id, $name, $email, $phone, $vehicle_type, $location, $status, $rider_image);
}

function delete_rider_ctr($id){
    $rider = new delivery_rider_class();
    return $rider->delete_rider($id);
}

function filter_riders_ctr($location, $vehicle_type){
    $rider = new delivery_rider_class();
    return $rider->filter_riders($location, $vehicle_type);
}
?>
