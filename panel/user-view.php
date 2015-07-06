<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>user View</title>
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
		<div id="head">	 <?php head_custom_menu(); ?>	</div>

 		<div id="container">
	 		<div id="content">
	 			<?php view_user_menu();  ?>
	 			<?php

	 				$id=$_GET['m_id'];
					view_user($mysqli,$id);

	 			?>
	 		</div>
			<div id="sidebar_right">
				<div id="menu_bar">
					<?php show_panel() ?>

				</div>
			</div>
 		</div>
	</body>
</html>