<?php
require_once('../settings/db_class.php');

class UpdateTable extends db_connection {
    public function add_image_column() {
        if(!$this->db_connect()){
            return "Database connection failed";
        }

        $sql = "ALTER TABLE `delivery_riders` ADD COLUMN `rider_image` VARCHAR(255) DEFAULT NULL AFTER `status`;";

        if($this->db_query($sql)){
            return "Column 'rider_image' added successfully.";
        } else {
            return "Error adding column: " . mysqli_error($this->db);
        }
    }
}

$updater = new UpdateTable();
echo $updater->add_image_column();
?>
