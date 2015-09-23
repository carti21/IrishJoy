<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Administration admin</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
 		<div class="container">
 			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_admin_menu(); ?>
				</div>
			</div>
		 	<div class="content">
		 		<div class="admin_latest_posts_left">
					<?php latest_posts_left($mysql_conn); ?>
		 		</div>
		 		<div class="admin_latest_posts_right">
					<?php latest_posts_right($mysql_conn); ?>
		 		</div>
		 	</div>		 		
 		</div>		
	<?php footer_requires($mysql_conn); ?>