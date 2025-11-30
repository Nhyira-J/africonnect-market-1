<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

$sql = "DESCRIBE products";
$result = mysqli_query($conn, $sql);

if($result){
    echo "Columns in products table:\n";
    while($row = mysqli_fetch_assoc($result)){
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
