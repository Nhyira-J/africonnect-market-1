<?php
session_start();
include("../controllers/review_controller.php");

if(isset($_POST['submit_review'])){
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : '';

    $result = add_platform_review_ctr($user_id, $rating, $comment);

    if($result){
        // Redirect back with success message and keep invoice number
        header("Location: ../view/track.php?success=review_added&invoice_no=$invoice_no");
    } else {
        header("Location: ../view/track.php?error=failed&invoice_no=$invoice_no");
    }
}
?>
