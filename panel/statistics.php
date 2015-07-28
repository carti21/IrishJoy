<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Statistics</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
	 		<div class="content">
				<div class="content"> 
					<?php show_statistics($mysqli); ?>
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

					