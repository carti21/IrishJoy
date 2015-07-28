<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
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
					<?php show_login_attempts($mysqli); ?>
	    		</div>
	 		</div>
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_panel_menu(); ?>
				</div>
			</div>
		</div>
	</body>
</html>

					