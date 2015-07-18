<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Administration Panel</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
 		<div class="container">
 			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_panel() ?>
				</div>
			</div>
		 	<div class="content">
		 	
                <?php show_statistics($mysqli); ?>
		 		
		 	</div>		 		
 		</div>		
	</body>
</html>