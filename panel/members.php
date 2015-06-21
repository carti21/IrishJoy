<?php 
include 'includes/db_connect.php';
include 'includes/functions.php';
error_reporting(0); // jane gabime qe duhen pare ne fund !!! 
	// Include database connection and functions here.
sec_session_start();
if(login_check($mysqli) == true) {
 
   // Add your protected page content here!
 
} else {
   header('Location: ./');
}

 ?>


<?php 
		if($_GET['del']==1)
		{
			if($_GET['id']>0)
			{
				delete_member($mysqli,$_GET['id']);
				header("Location: members.php"); 
			}
		}
?>
<?php 
		 if($_GET['edit']==1)
		 {
		 	header("Location: members-edit.php?id=".$_GET['id']);
		}  
?>

<html>
	<head>
		<title>Members</title>
		<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
		<link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon"> 
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

			<div id="head"> <?php head_custom_menu(); ?> </div>
				 

 			<div id="container">
		 		<div id="content">
		 			<div> <?php show_member_menu(); ?> </div>
					
					
							 
					<?php show_members($mysqli); ?>
		    		
		    		
		 			
		 			
		 		</div>
		 		
				<div id="sidebar_right">
					<div id="menu_bar">
						<?php show_panel() ?>
					</div>
				</div>
 
 		</div>
 

</body>
</html>

					