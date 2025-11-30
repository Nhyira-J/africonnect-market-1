<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

// Check if columns exist
$check_otp = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'otp_code'");
if(mysqli_num_rows($check_otp) == 0){
    $sql = "ALTER TABLE users 
            ADD COLUMN otp_code VARCHAR(6) NULL,
            ADD COLUMN otp_expiry DATETIME NULL,
            ADD COLUMN is_email_verified TINYINT(1) DEFAULT 0";
            
    if(mysqli_query($conn, $sql)){
        echo "Successfully added OTP columns to users table.\n";
    } else {
        echo "Error adding columns: " . mysqli_error($conn) . "\n";
    }
} else {
    echo "OTP columns already exist.\n";
}
?>
