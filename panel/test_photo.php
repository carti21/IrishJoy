<?php 
	include 'includes/db_connect.php';
	include 'includes/functions.php';
	error_reporting(); // jane gabime qe duhen pare ne fund !!! 
		// Include database connection and functions here.
	sec_session_start();
	if(login_check($mysqli) == true) {
	 
	   // Add your protected page content here!
	 
	} else {
	   header('Location: ./login.php');
	}

 ?>


<html>
	<head>
		<title>Test photo</title>
		<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
		
		
	</head>
<body>

			<div id="head">
				<div id="right_head_bar"> </div>
			</div>
 		
 			<div id="container">
 			<div id="content">
		 		
		 	<?php 	
				$i=0;
				$dirname = "test_images/";

				$images = glob($dirname."*");
				
				//Display image using foreach loop
				foreach($images as $image) {
				
					if($i % 2==0){
					echo "<div id=\"single_img_style_left\"><a href=\"$image\" target=\"_blank\">
						  <img src=\"$image\"/></a></div>";
						  $i++;
					}
					else{
						echo "<div id=\"single_img_style_right\"><a href=\"$image\" target=\"_blank\">
						  <img src=\"$image\"/></a></div>";
						    $i++;
					}
				}
		 	 ?>
		 		</div>
				<div id="sidebar_right">
					<div id="menu_bar">
						<?php show_panel() ?>
					</div>
				</div>
 
 		
 		</div>
 
 		<div id="footer"> </div>

</body>
</html>