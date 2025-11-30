<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

// Create table
$sql_create = "CREATE TABLE IF NOT EXISTS `system_settings` (
    `setting_id` int(11) NOT NULL AUTO_INCREMENT,
    `setting_key` varchar(100) NOT NULL UNIQUE,
    `setting_value` text NOT NULL,
    PRIMARY KEY (`setting_id`)
)";

if(mysqli_query($conn, $sql_create)){
    echo "Table 'system_settings' created successfully.\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}

// Settings to insert
$settings = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_username' => 'henryowusu023@gmail.com',
    'smtp_password' => 'ptcm imoo npjf qbqu',
    'smtp_port' => '587',
    'smtp_encryption' => 'tls',
    'from_email' => 'henryowusu023@gmail.com',
    'from_name' => 'AfriConnect'
];

foreach($settings as $key => $value){
    $key = mysqli_real_escape_string($conn, $key);
    $value = mysqli_real_escape_string($conn, $value);
    
    // Check if exists
    $check = "SELECT * FROM system_settings WHERE setting_key = '$key'";
    $res = mysqli_query($conn, $check);
    
    if(mysqli_num_rows($res) > 0){
        // Update
        $sql = "UPDATE system_settings SET setting_value = '$value' WHERE setting_key = '$key'";
        if(mysqli_query($conn, $sql)){
            echo "Updated $key.\n";
        } else {
            echo "Error updating $key: " . mysqli_error($conn) . "\n";
        }
    } else {
        // Insert
        $sql = "INSERT INTO system_settings (setting_key, setting_value) VALUES ('$key', '$value')";
        if(mysqli_query($conn, $sql)){
            echo "Inserted $key.\n";
        } else {
            echo "Error inserting $key: " . mysqli_error($conn) . "\n";
        }
    }
}

echo "Settings setup complete.\n";
?>
