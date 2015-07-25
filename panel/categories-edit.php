<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Add a new Categorie</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head">
			<div class="right_head_bar"></div>
		</div>
		<div class="container">
 			<div class="users_new" style="width: 350px">
				<div>	 
					<form action="" method="post"></br></br>
						<label>Edit Category</label>
						<input type="text" name="new_category" value="<?php echo get_category_by_id($mysqli, $_GET['id'])?>"/>  </br></br></br>
						<div style="float:right;">
							<button class="content_button" name="add_category">Update Category</button>
						</div>	
						<div style="float:left; margin-right: 5px;">
							<a href="categories.php" class="post-details" target="__blank">Go back to category</a>
						</div>	
					</form>
						<?php
							if (isset($_POST['new_category']))
							{
								edit_category($mysqli, $_POST['new_category'], $_GET['id'] );
								header('Location: ./categories.php');
							}
						?>
	    		</div>
	 		</div>
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_panel() ?>
				</div>
			</div>
		</div>
	</body>
</html>

					