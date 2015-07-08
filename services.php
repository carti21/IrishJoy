<?php  
	

		$app_info = file_get_contents('http://localhost/pro/api/api.php?action=categories');
  		$app_info = json_decode($app_info, true);

  		foreach ($app_info as $a){
  			echo $a['id']. ' ' . $a['category_name']; echo '</br>';
  		}
 	