<?php 

	
	$root = realpath(__DIR__  . '/..');
	include "$root/panel/functions.php";

	if (isset($_GET['action'])){
		if($_GET['action'] == 'posts'){
			echo "this is the list of the posts";
		} elseif($_GET['action'] == 'categories' ){
			$query = "SELECT * FROM categories";
        	$result = mysqli_query($mysqli, $query) or die(mysqli_error());
         	
         	$categories = array(); 
            while($row = mysqli_fetch_array($result)){
            	$current_category = array();
            	$current_category['id'] = $row['id'];
            	$current_category['category_name'] = $row['category_name'];

            	//$categories[] = $current_category;
            	array_push($categories, $current_category);
            } 

            /*$categories = json_encode($categories);
            return $categories;*/

            exit(json_encode($categories));
           
		}
	} else {

		echo "No action is allowed!";
	}
?>
