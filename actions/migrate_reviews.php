<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

$sql = "CREATE TABLE IF NOT EXISTS platform_reviews (
    review_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    rating INT(1) NOT NULL,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)";

if(mysqli_query($conn, $sql)){
    echo "Successfully created platform_reviews table.\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}
?>
