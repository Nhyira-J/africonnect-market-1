<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

$sql = "DESCRIBE artisans";
$result = mysqli_query($conn, $sql);

if($result){
    echo "Columns in artisans table:\n";
    while($row = mysqli_fetch_assoc($result)){
        echo $row['Field'] . " - " . $row['Type'] . " - Default: " . $row['Default'] . "\n";
    }
} else {
    echo "Error describing table: " . mysqli_error($conn);
}
?>
