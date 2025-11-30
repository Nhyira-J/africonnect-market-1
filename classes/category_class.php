<?php
//connect to database class
require_once("../settings/db_class.php");

class category_class extends db_connection
{
    public function add_category($name, $description)
	{
		$ndb = new db_connection();	
		$name =  mysqli_real_escape_string($ndb->db_conn(), $name);
		$description =  mysqli_real_escape_string($ndb->db_conn(), $description);
		
        // Check if category exists
        $check_sql = "SELECT category_id FROM categories WHERE name = '$name' LIMIT 1";
        $this->db_query($check_sql);
        if ($this->db_count() > 0) {
            return "duplicate";
        }

		$sql="INSERT INTO `categories`(`name`, `description`) VALUES ('$name', '$description')";
		return $this->db_query($sql);
	}


    public function view_all_categories()
    {
        $sql = "SELECT * FROM categories";
        return $this->db_fetch_all($sql);
    }

    public function get_category($id)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $sql = "SELECT * FROM categories WHERE category_id = '$id'";
        return $this->db_fetch_one($sql);
    }

    public function update_category($id, $name, $description)
    {
        $ndb = new db_connection();	
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $name = mysqli_real_escape_string($ndb->db_conn(), $name);
        $description = mysqli_real_escape_string($ndb->db_conn(), $description);

        $sql = "UPDATE `categories` SET `name`='$name', `description`='$description' WHERE `category_id`='$id'";
        return $this->db_query($sql);
    }


    public function delete_category($id)
    {
        $ndb = new db_connection();	
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);

        $sql = "DELETE FROM `categories` WHERE `category_id`='$id'";
        return $this->db_query($sql);
    }
}
?>