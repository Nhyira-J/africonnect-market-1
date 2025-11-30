<?php
require_once("../settings/db_class.php");

class product_class extends db_connection
{
    public function add_product($artisan_id, $name, $description, $price, $quantity, $category_id, $brand_id, $estimated_delivery_time, $image_url, $stock_status)
    {
        // Connect to database
        if(!$this->db_connect()){
            return false;
        }

        // Escape variables using the active connection
        $artisan_id = mysqli_real_escape_string($this->db, $artisan_id);
        $name = mysqli_real_escape_string($this->db, $name);
        $description = mysqli_real_escape_string($this->db, $description);
        $price = mysqli_real_escape_string($this->db, $price);
        $quantity = mysqli_real_escape_string($this->db, $quantity);
        $category_id = mysqli_real_escape_string($this->db, $category_id);
        
        // Handle optional brand_id
        if($brand_id === NULL){
            $brand_id_sql = "NULL";
        } else {
            $brand_id_sql = "'" . mysqli_real_escape_string($this->db, $brand_id) . "'";
        }

        $estimated_delivery_time = mysqli_real_escape_string($this->db, $estimated_delivery_time);
        $image_url = mysqli_real_escape_string($this->db, $image_url);
        $stock_status = mysqli_real_escape_string($this->db, $stock_status);

        $sql = "INSERT INTO `products` 
                (`artisan_id`, `name`, `description`, `price`, `quantity`, `category_id`, `brand_id`, `estimated_delivery_time`, `image_url`, `stock_status`) 
                VALUES 
                ('$artisan_id', '$name', '$description', '$price', '$quantity', '$category_id', $brand_id_sql, '$estimated_delivery_time', '$image_url', '$stock_status')";
        
        // Execute query using the same connection
        $this->results = mysqli_query($this->db, $sql);

        if($this->results){
            return true;
        } else {
            return false;
        }
    }

    public function view_all_products()
    {
        $sql = "SELECT p.*, c.name as category_name, a.business_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.category_id 
                JOIN artisans a ON p.artisan_id = a.artisan_id
                WHERE a.verified = 1";
        return $this->db_fetch_all($sql);
    }

    public function view_products_by_artisan($artisan_id)
    {
        $ndb = new db_connection();
        $artisan_id = mysqli_real_escape_string($ndb->db_conn(), $artisan_id);
        $sql = "SELECT * FROM products WHERE artisan_id = '$artisan_id'";
        return $this->db_fetch_all($sql);
    }

    public function view_one_product($id)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $sql = "SELECT p.*, c.name as category_name, a.business_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.category_id 
                JOIN artisans a ON p.artisan_id = a.artisan_id
                WHERE p.product_id = '$id' AND a.verified = 1";
        return $this->db_fetch_one($sql);
    }

    public function search_products($term)
    {
        $ndb = new db_connection();
        $term = mysqli_real_escape_string($ndb->db_conn(), $term);
        $sql = "SELECT p.* FROM products p 
                JOIN artisans a ON p.artisan_id = a.artisan_id
                WHERE (p.name LIKE '%$term%' OR p.description LIKE '%$term%') AND a.verified = 1";
        return $this->db_fetch_all($sql);
    }
    
    public function get_products_by_category($cat_id)
    {
        $ndb = new db_connection();
        $cat_id = mysqli_real_escape_string($ndb->db_conn(), $cat_id);
        $sql = "SELECT p.* FROM products p 
                JOIN artisans a ON p.artisan_id = a.artisan_id
                WHERE p.category_id = '$cat_id' AND a.verified = 1";
        return $this->db_fetch_all($sql);
    }

    public function update_product($id, $name, $description, $price, $quantity, $category_id, $brand_id, $estimated_delivery_time, $image_url, $stock_status)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $name = mysqli_real_escape_string($ndb->db_conn(), $name);
        $description = mysqli_real_escape_string($ndb->db_conn(), $description);
        $price = mysqli_real_escape_string($ndb->db_conn(), $price);
        $quantity = mysqli_real_escape_string($ndb->db_conn(), $quantity);
        $category_id = mysqli_real_escape_string($ndb->db_conn(), $category_id);
        $brand_id = $brand_id ? "'" . mysqli_real_escape_string($ndb->db_conn(), $brand_id) . "'" : "NULL";
        $estimated_delivery_time = mysqli_real_escape_string($ndb->db_conn(), $estimated_delivery_time);
        $image_url = mysqli_real_escape_string($ndb->db_conn(), $image_url);
        $stock_status = mysqli_real_escape_string($ndb->db_conn(), $stock_status);

        $sql = "UPDATE `products` SET 
                `name`='$name', 
                `description`='$description', 
                `price`='$price', 
                `quantity`='$quantity',
                `category_id`='$category_id', 
                `brand_id`=$brand_id, 
                `estimated_delivery_time`='$estimated_delivery_time', 
                `image_url`='$image_url', 
                `stock_status`='$stock_status' 
                WHERE `product_id`='$id'";
        
        return $this->db_query($sql);
    }

    public function delete_product($id)
    {
        $ndb = new db_connection();
        $id = mysqli_real_escape_string($ndb->db_conn(), $id);
        $sql = "DELETE FROM `products` WHERE `product_id`='$id'";
        return $this->db_query($sql);
    }

    public function filter_products($category_id, $min_price, $max_price, $search_term)
    {
        $ndb = new db_connection();
        $conn = $ndb->db_conn();
        
        $conditions = ["a.verified = 1"];
        
        if (!empty($category_id)) {
            $category_id = mysqli_real_escape_string($conn, $category_id);
            $conditions[] = "p.category_id = '$category_id'";
        }
        
        if (!empty($min_price)) {
            $min_price = mysqli_real_escape_string($conn, $min_price);
            $conditions[] = "p.price >= '$min_price'";
        }
        
        if (!empty($max_price)) {
            $max_price = mysqli_real_escape_string($conn, $max_price);
            $conditions[] = "p.price <= '$max_price'";
        }
        
        if (!empty($search_term)) {
            $search_term = mysqli_real_escape_string($conn, $search_term);
            $conditions[] = "(p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%')";
        }
        
        $sql = "SELECT p.*, c.name as category_name, a.business_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.category_id 
                JOIN artisans a ON p.artisan_id = a.artisan_id";
                
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        return $this->db_fetch_all($sql);
    }
}
?>
