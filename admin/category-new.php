<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Add a Category</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
		 	<div class="content">
				<?php show_category_menu(); ?>
	 			<div class="users_new">
					<form action="" method="post"><br><br>
						<label>New Category</label>
						<input type="text" name="new_category" />  <br><br><br>
						<div class="pull-right">
							<button class="content_button" name="add_category"> Add Category </button>
						</div>	
						<div class="pull-left">
							<a href="categories.php" target="__blank">Go back to category</a>
						</div>	
					</form>
						<?php
							if (isset($_POST['new_category'])){
								add_category($mysql_conn,$_POST['new_category']);
							}
						?>
		 		</div>
			</div>
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_admin_menu() ?>
				</div>
			</div>
		</div>
	<?php footer_requires($mysql_conn); ?>

					