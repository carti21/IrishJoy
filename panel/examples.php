<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>My Examples</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
	 		<div class="content">
				<div class="content"> 
					<h2>My Examples</h2>
					<!-- Place your Example's code here. --> 


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

					