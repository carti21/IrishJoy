<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>users login attempts</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
	 		<div class="content">
				<div class="content"> 
					<div><?php show_user_menu(); ?> </div>
					<?php show_login_attempts($mysql_conn); ?>
	    		</div>
	 		</div>
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_admin_menu(); ?>
				</div>
			</div>
		</div>
	<?php footer_requires($mysql_conn); ?>

					