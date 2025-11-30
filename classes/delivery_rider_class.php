<?php
require_once("../settings/db_class.php");

class delivery_rider_class extends db_connection
{
    public function add_rider($name, $email, $phone, $vehicle_type, $location, $status, $rider_image)
    {
        if(!$this->db_connect()){
            return false;
        }

        $name = mysqli_real_escape_string($this->db, $name);
        $email = mysqli_real_escape_string($this->db, $email);
        $phone = mysqli_real_escape_string($this->db, $phone);
        $vehicle_type = mysqli_real_escape_string($this->db, $vehicle_type);
        $location = mysqli_real_escape_string($this->db, $location);
        $status = mysqli_real_escape_string($this->db, $status);
        $rider_image = mysqli_real_escape_string($this->db, $rider_image);

        $sql = "INSERT INTO `delivery_riders` (`name`, `email`, `phone`, `vehicle_type`, `location`, `status`, `rider_image`) 
                VALUES ('$name', '$email', '$phone', '$vehicle_type', '$location', '$status', '$rider_image')";
        
        return $this->db_query($sql);
    }

    public function view_all_riders()
    {
        $sql = "SELECT * FROM `delivery_riders` ORDER BY `created_at` DESC";
        return $this->db_fetch_all($sql);
    }

    public function view_one_rider($id)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $sql = "SELECT * FROM `delivery_riders` WHERE `rider_id` = '$id'";
        return $this->db_fetch_one($sql);
    }

    public function update_rider($id, $name, $email, $phone, $vehicle_type, $location, $status, $rider_image)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $name = mysqli_real_escape_string($ndb->db_conn(), $name);
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $phone = mysqli_real_escape_string($ndb->db_conn(), $phone);
        $vehicle_type = mysqli_real_escape_string($ndb->db_conn(), $vehicle_type);
        $location = mysqli_real_escape_string($ndb->db_conn(), $location);
        $status = mysqli_real_escape_string($ndb->db_conn(), $status);
        $rider_image = mysqli_real_escape_string($ndb->db_conn(), $rider_image);

        $sql = "UPDATE `delivery_riders` SET 
                `name`='$name', 
                `email`='$email', 
                `phone`='$phone', 
                `vehicle_type`='$vehicle_type', 
                `location`='$location', 
                `status`='$status',
                `rider_image`='$rider_image'
                WHERE `rider_id`='$id'";
        
        return $this->db_query($sql);
    }

    public function delete_rider($id)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $sql = "DELETE FROM `delivery_riders` WHERE `rider_id`='$id'";
        return $this->db_query($sql);
    }

    public function filter_riders($location, $vehicle_type)
    {
        $ndb = new db_connection();
        $location = mysqli_real_escape_string($ndb->db_conn(), $location);
        $vehicle_type = mysqli_real_escape_string($ndb->db_conn(), $vehicle_type);
        
        $sql = "SELECT * FROM `delivery_riders` WHERE 1=1";
        
        if(!empty($location)){
            $sql .= " AND `location` LIKE '%$location%'";
        }
        
        if(!empty($vehicle_type)){
            $sql .= " AND `vehicle_type` = '$vehicle_type'";
        }
        
        $sql .= " ORDER BY `created_at` DESC";
        
        return $this->db_fetch_all($sql);
    }
}
?>
