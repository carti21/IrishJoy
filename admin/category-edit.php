<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Add a new Categorie</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
 			<div class="content">
				<div>	 
					<form action="" method="post"><br><br>
						<label>Edit Category</label>
						<input type="text" name="new_category" value="<?php echo get_category_name($mysql_conn, $_GET['id'])?>"/><br><br><br>
						<div class="pull-right">
							<button class="content_button" name="add_category">Update Category</button>
						</div>	
						<div class="pull-left">
							<a href="categories.php" class="post-details" target="__blank">Go back to category</a>
						</div>	
					</form>
						<?php
							if (isset($_POST['new_category'])){
								edit_category($mysql_conn, $_POST['new_category'], $_GET['id'] );
							
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

					