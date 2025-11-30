<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

// Check if column exists
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM products LIKE 'quantity'");
if(mysqli_num_rows($check_col) == 0){
    $sql = "ALTER TABLE products ADD COLUMN quantity INT(11) DEFAULT 0 AFTER price";
            
    if(mysqli_query($conn, $sql)){
        echo "Successfully added quantity column to products table.\n";
    } else {
        echo "Error adding column: " . mysqli_error($conn) . "\n";
    }
} else {
    echo "Quantity column already exists.\n";
}
?>
