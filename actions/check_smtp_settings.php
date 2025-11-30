<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

$sql = "SELECT * FROM system_settings WHERE setting_key LIKE 'smtp_%' OR setting_key LIKE 'from_%'";
$result = mysqli_query($conn, $sql);

if($result){
    echo "SMTP Settings:\n";
    while($row = mysqli_fetch_assoc($result)){
        echo $row['setting_key'] . ": " . $row['setting_value'] . "\n";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
