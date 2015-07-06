<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>users login attempts</title>
		<?php header_requires(); ?>
	<script>
		$("button#1").ready(function(){
		  $("#custom_menu1").hide();
		    $("#custom_menu2").hide();
		    $("#custom_menu3").hide();
		  $("button").click(function(){
		    $("#custom_menu1").fadeToggle(400);
		    $("#custom_menu2").fadeToggle(600);
		    $("#custom_menu3").fadeToggle(800);
		  });
		});
	</script>
	</head>
<body>

			<div id="head">
				 <?php head_custom_menu(); ?>

		    		</div>
			</div>
 		
 			<div id="container">
		 		<div id="content">
					<div id="content"> 
						<div><?php show_user_menu(); ?> </div>
					
							 
					<?php show_login_attempts($mysqli); ?>
		    		
		    		</div>
		 			
		 			
		 		</div>
		 		
				<div id="sidebar_right">
					<div id="menu_bar">
						<?php show_panel() ?>
					</div>
				</div>
 
 		</div>
  	

</body>
</html>

					