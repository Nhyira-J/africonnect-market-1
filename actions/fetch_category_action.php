<?php
//connect to the category controller
include("../controllers/category_controller.php");

//fetch all categories
//fetch all categories
$categories = view_all_categories_ctr();
if(!$categories){
    $errors[] = "No categories found";
    $categories = []; // Ensure it's an array to prevent foreach error
}

//sanitize data
// if(isset($_POST['fetch_categories'])){
// 	//call the controller function      
// 	$result = get_all_cat_ctr();
// 	if($result){
// 		$categories = $result;
// 	}else{
// 		$errors[] = "Failed to fetch categories";   
// 	}
// }
?>