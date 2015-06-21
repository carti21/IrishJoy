<?php 
include 'includes/db_connect.php';
include 'includes/functions.php';
error_reporting(0); 
	// Include database connection and functions here.
sec_session_start();
if(login_check($mysqli) == true) {
 
   // Add your protected page content here!
 
} else {
   header('Location: ./');
}
 ?>
<?php	$post_id = $_GET['p_id'];	 ?>


<html>
<head>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Image</title>
<link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon"> 
	<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
		$("#custom_menu_button").ready(function(){
		  $("#custom_menu1").hide();
		    $("#custom_menu2").hide();
		    $("#custom_menu3").hide();
		  $("#custom_menu_button").click(function(){
		    $("#custom_menu1").fadeToggle(400);
		    $("#custom_menu2").fadeToggle(600);
		    $("#custom_menu3").fadeToggle(800);
		  });
		});
	</script>



</head>



<body>
<div id="head">	 <?php head_custom_menu(); ?>	</div>
		


	
	
</div>
 		
 		<div id="container">
		 		<div id="content">
 			
 			<?php 
	 			view_image_menu($mysqli,$post_id);	  
			 ?>
 			
 			<?php view_image($mysqli,$post_id )	 ?>
		 		 

		 		</div>
		 		
				<div id="sidebar_right">
					
					<div id="menu_bar">
						<?php show_panel() ?>
					
					
					
					
					
					</div>
				
				</div>
 
 		</div>
 
 		




</body>
</html>