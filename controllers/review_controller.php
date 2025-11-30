<?php
require_once("../classes/review_class.php");

function add_platform_review_ctr($user_id, $rating, $comment){
    $review = new review_class();
    return $review->add_platform_review($user_id, $rating, $comment);
}
?>
