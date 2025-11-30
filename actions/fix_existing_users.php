<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

// Update existing users to be verified
$sql = "UPDATE users SET is_email_verified = 1 WHERE is_email_verified IS NULL OR is_email_verified = 0";

if(mysqli_query($conn, $sql)){
    echo "Successfully updated existing users to be verified.\n";
} else {
    echo "Error updating users: " . mysqli_error($conn) . "\n";
}
?>
