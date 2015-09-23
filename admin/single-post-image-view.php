<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }

	$post_id = $_GET['post-id'];	 
?>

<html>
	<head>
		<title>View Image</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
			<div class="content">
				<?php 
					view_single_post_image_menu($mysql_conn,$post_id);
					view_single_post_image($mysql_conn,$post_id);
				?>
			</div>
			<div class="sidebar_right">	
				<div class="menu_bar">
					<?php show_admin_menu(); ?>
				</div>
			</div>
		</div>
	<?php footer_requires($mysql_conn); ?>