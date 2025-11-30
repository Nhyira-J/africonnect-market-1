<?php
require_once("../settings/db_class.php");

$db = new db_connection();
$conn = $db->db_conn();

$sql = "SELECT user_id, email, is_email_verified FROM users LIMIT 10";
$result = mysqli_query($conn, $sql);

if($result){
    echo "User Verification Status:\n";
    while($row = mysqli_fetch_assoc($result)){
        echo "ID: " . $row['user_id'] . " | Email: " . $row['email'] . " | Verified: " . ($row['is_email_verified'] ?? 'NULL') . "\n";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
