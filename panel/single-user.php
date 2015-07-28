<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>User View</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head">
            <div class="right_head_bar"></div>
        </div>
 		<div class="container">
	 		<div class="content">
	 			<?php view_user_menu();  ?>
	 			<?php

	 				$id=$_GET['m_id'];
					view_single_user($mysqli,$id);

	 			?>
	 		</div>
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_panel_menu(); ?>

				</div>
			</div>
 		</div>
	</body>
</html>