<?php
require_once("../settings/db_class.php");

class review_class extends db_connection
{
    public function add_platform_review($user_id, $rating, $comment)
    {
        $ndb = new db_connection();
        $user_id = mysqli_real_escape_string($ndb->db_conn(), $user_id);
        $rating = mysqli_real_escape_string($ndb->db_conn(), $rating);
        $comment = mysqli_real_escape_string($ndb->db_conn(), $comment);

        $sql = "INSERT INTO `platform_reviews` (`user_id`, `rating`, `comment`) VALUES ('$user_id', '$rating', '$comment')";
        
        return $this->db_query($sql);
    }
}
?>
