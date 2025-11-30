<?php
//connect to database class
require_once("../settings/db_class.php");

class customer_class extends db_connection
{
    public function email_exists($email) {
        $ndb = new db_connection();	
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);

        $sql = "SELECT user_id FROM users WHERE email = '$email' LIMIT 1";
        $result = $this->db_query($sql);

        return ($this->db_count() > 0); 
    }

    public function add_user($full_name, $email, $phone, $password, $address, $country, $city, $role, $business_name = null, $bio = null)
    {
        $ndb = new db_connection();	

        $full_name = mysqli_real_escape_string($ndb->db_conn(), $full_name);
        $email     = mysqli_real_escape_string($ndb->db_conn(), $email);
        $phone     = mysqli_real_escape_string($ndb->db_conn(), $phone);
        $password  = mysqli_real_escape_string($ndb->db_conn(), $password);
        $address   = mysqli_real_escape_string($ndb->db_conn(), $address);
        $role      = mysqli_real_escape_string($ndb->db_conn(), $role);
        
        $full_address = $address . ", " . $city . ", " . $country;
        $full_address = mysqli_real_escape_string($ndb->db_conn(), $full_address);

        if ($this->email_exists($email)) {
            return "duplicate"; 
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Generate OTP
        $otp_code = rand(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

        // 1. Insert into users table
        $sql_user = "INSERT INTO `users`
                (`full_name`, `email`, `phone`, `password_hash`, `address`, `user_type`, `otp_code`, `otp_expiry`, `is_email_verified`) 
                VALUES ('$full_name','$email','$phone','$hashedPassword','$full_address','$role', '$otp_code', '$otp_expiry', 0)";
        
        if($this->db_query($sql_user)){
            $user_id = $this->insert_id();
            
            // 2. Insert into specific role table
            if($role == 'customer'){
                $sql_role = "INSERT INTO `customers` (`user_id`) VALUES ('$user_id')";
                $this->db_query($sql_role);
            } elseif($role == 'artisan'){
                $business_name = $business_name ? mysqli_real_escape_string($ndb->db_conn(), $business_name) : $full_name;
                $bio = $bio ? mysqli_real_escape_string($ndb->db_conn(), $bio) : '';
                
                $sql_role = "INSERT INTO `artisans` (`user_id`, `business_name`, `bio`) VALUES ('$user_id', '$business_name', '$bio')";
                $this->db_query($sql_role);
            }
            
            // Return user info for OTP email
            return ['status' => true, 'user_id' => $user_id, 'otp_code' => $otp_code];
        } else {
            return false;
        }
    }

    public function login_user($email, $password)
    {
        $ndb   = new db_connection();
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $password = mysqli_real_escape_string($ndb->db_conn(), $password);

        // Fetch user by email - REMOVED user_type check to allow all roles
        $sql = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
        $result = $this->db_fetch_one($sql);

        if ($result) {
            // Verify password
            if (password_verify($password, $result['password_hash'])) {
                
                // Check if email is verified
                // If is_email_verified is explicitly 0, then block. If NULL (legacy), allow.
                if(isset($result['is_email_verified']) && $result['is_email_verified'] == 0){
                    return "unverified_email";
                }

                $user_data = [
                    'status' => 'success',
                    'user_id' => $result['user_id'],
                    'full_name' => $result['full_name'],
                    'email' => $result['email'],
                    'user_type' => $result['user_type']
                ];

                // Fetch role specific ID
                if($result['user_type'] == 'customer'){
                    $sql_cust = "SELECT customer_id FROM customers WHERE user_id = '" . $result['user_id'] . "' LIMIT 1";
                    $cust_result = $this->db_fetch_one($sql_cust);
                    if($cust_result) $user_data['customer_id'] = $cust_result['customer_id'];
                } elseif($result['user_type'] == 'artisan'){
                    $sql_art = "SELECT artisan_id FROM artisans WHERE user_id = '" . $result['user_id'] . "' LIMIT 1";
                    $art_result = $this->db_fetch_one($sql_art);
                    if($art_result) $user_data['artisan_id'] = $art_result['artisan_id'];
                }

                return $user_data;
            } else {
                return "invalid_password";
            }
        } else {
            return "not_found"; 
        }
    }

    public function get_customer_details($user_id) {
        $ndb = new db_connection();
        $user_id = mysqli_real_escape_string($ndb->db_conn(), $user_id);
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
        return $this->db_fetch_one($sql);
    }

    public function get_customer_by_id($customer_id) {
        $ndb = new db_connection();
        $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
        $sql = "SELECT * FROM `customers` WHERE `customer_id` = '$customer_id'";
        return $this->db_fetch_one($sql);
    }

    public function get_artisan_details($user_id) {
        $ndb = new db_connection();
        $user_id = mysqli_real_escape_string($ndb->db_conn(), $user_id);
        $sql = "SELECT u.*, a.business_name, a.bio, a.verified 
                FROM users u 
                JOIN artisans a ON u.user_id = a.user_id 
                WHERE u.user_id = '$user_id'";
        return $this->db_fetch_one($sql);
    }

    public function update_artisan_profile($user_id, $business_name, $bio, $phone, $address) {
        $ndb = new db_connection();
        $user_id = mysqli_real_escape_string($ndb->db_conn(), $user_id);
        $business_name = mysqli_real_escape_string($ndb->db_conn(), $business_name);
        $bio = mysqli_real_escape_string($ndb->db_conn(), $bio);
        $phone = mysqli_real_escape_string($ndb->db_conn(), $phone);
        $address = mysqli_real_escape_string($ndb->db_conn(), $address);

        // Update users table
        $sql_user = "UPDATE users SET phone = '$phone', address = '$address' WHERE user_id = '$user_id'";
        $this->db_query($sql_user);

        // Update artisans table
        $sql_artisan = "UPDATE artisans SET business_name = '$business_name', bio = '$bio' WHERE user_id = '$user_id'";
        return $this->db_query($sql_artisan);
    }

    public function get_all_users() {
        $sql = "SELECT * FROM users";
        return $this->db_fetch_all($sql);
    }

    public function get_recent_users() {
        $sql = "SELECT * FROM users ORDER BY user_id DESC LIMIT 5";
        return $this->db_fetch_all($sql);
    }

    public function get_unverified_artisans() {
        $sql = "SELECT u.*, a.artisan_id, a.business_name, a.bio, a.verified 
                FROM users u 
                JOIN artisans a ON u.user_id = a.user_id 
                WHERE a.verified = 0";
        return $this->db_fetch_all($sql);
    }

    public function verify_artisan($artisan_id) {
        $ndb = new db_connection();
        $artisan_id = mysqli_real_escape_string($ndb->db_conn(), $artisan_id);
        $sql = "UPDATE artisans SET verified = 1 WHERE artisan_id = '$artisan_id'";
        return $this->db_query($sql);
    }

    public function verify_otp($user_id, $otp) {
        $ndb = new db_connection();
        $user_id = mysqli_real_escape_string($ndb->db_conn(), $user_id);
        $otp = mysqli_real_escape_string($ndb->db_conn(), $otp);
        
        $sql = "SELECT * FROM users WHERE user_id = '$user_id' AND otp_code = '$otp' AND otp_expiry > NOW()";
        $result = $this->db_fetch_one($sql);
        
        if($result){
            // Mark as verified and clear OTP
            $update_sql = "UPDATE users SET is_email_verified = 1, otp_code = NULL, otp_expiry = NULL WHERE user_id = '$user_id'";
            return $this->db_query($update_sql);
        }
        return false;
    }
}
?>