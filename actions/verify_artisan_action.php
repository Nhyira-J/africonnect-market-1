<?php
session_start();
include("../controllers/customer_controller.php");

if(isset($_POST['verify'])){
    $artisan_id = $_POST['artisan_id'];
    
    $result = verify_artisan_ctr($artisan_id);
    
    if($result){
        // Fetch artisan details to get email
        $artisan = get_artisan_details_ctr($artisan_id); // Assuming this function exists or need to fetch user details
        // Actually get_artisan_details_ctr takes user_id, but we have artisan_id. 
        // Let's fetch the user email directly using a new query or helper.
        // For simplicity, let's assume we can get it. 
        // Wait, I need to get the email. Let's look at customer_class.
        
        // I'll use a direct query here for simplicity or add a method. 
        // Better to use existing methods. verify_artisan_ctr just returns boolean.
        // I should fetch the artisan details BEFORE verifying or fetch them now.
        
        // Let's use a quick query to get email
        require_once("../settings/db_class.php");
        $db = new db_connection();
        $conn = $db->db_conn();
        $sql = "SELECT u.email, u.full_name FROM users u JOIN artisans a ON u.user_id = a.user_id WHERE a.artisan_id = '$artisan_id'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        
        if($row){
            include("../functions/send_mail.php");
            $to = $row['email'];
            $name = $row['full_name'];
            $subject = "Account Verified - AfriConnect";
            $body = "Hello $name,\n\nCongratulations! Your artisan account has been verified by our admin team. You can now log in and start selling your products.\n\nLogin here: http://169.239.251.102:442/~jemima.nhyira/view/login.php\n\nRegards,\nAfriConnect Team";
            send_general_email($to, $subject, $body);
        }

        header("Location: ../admin/verify_artisans.php?success=verified");
    } else {
        header("Location: ../admin/verify_artisans.php?error=failed");
    }
} else {
    header("Location: ../admin/verify_artisans.php");
}
?>
