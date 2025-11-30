<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

// Check if column exists
$check = mysqli_query($conn, "SHOW COLUMNS FROM artisans LIKE 'verified'");
if(mysqli_num_rows($check) == 0){
    $sql = "ALTER TABLE artisans ADD COLUMN verified TINYINT(1) DEFAULT 0";
    if(mysqli_query($conn, $sql)){
        echo "Successfully added 'verified' column to artisans table.\n";
    } else {
        echo "Error adding column: " . mysqli_error($conn) . "\n";
    }
} else {
    echo "'verified' column already exists.\n";
}
?>
