<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }

	if($_GET['del']==1)
	{
		if($_GET['id']>0)
		{
			delete_user($mysqli,$_GET['id']);
			header("Location: users.php"); 
		}
	}
 
	if($_GET['edit']==1)
	{
		header("Location: users-edit.php?id=".$_GET['id']);
	}  
?>

<html>
	<head>
		<title>users</title>
		<?php header_requires(); ?>
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
		 			<div> <?php show_user_menu(); ?> </div>
					
					
							 
					<?php show_users($mysqli); ?>
		    		
		    		
		 			
		 			
		 		</div>
		 		
				<div id="sidebar_right">
					<div id="menu_bar">
						<?php show_panel() ?>
					</div>
				</div>
 
 		</div>
 

</body>
</html>

					