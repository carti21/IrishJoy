<?php
    require_once('includes/functions.php');

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
			<div class="right_head_bar"> </div>
		</div>
		<div class="container">
 			<div class="users_new" style="width: 350px">
				<div>	 
					<form action="" method="post"></br></br>
						<label>New Category Name</label>
						<input type="text" name="new_category" />  </br></br></br>
						<div style="float:right;">
							<button id="content" name="add_category" value="Add Category"> Add Category </button>
						</div>	
						<div style="float:left; margin-right: 5px;">
							<a href="categories.php" target="__blank">Go back to category</a>
						</div>	
					</form>
						<?php
							if (isset($_POST['new_category']))
							{
								new_category($mysqli,$_POST['new_category']);
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
		<div class="footer" ><div style="margin-left:580px; margin-top:0px"> &copy; www.irishjoy.flivetech.com 2013</div></div>
	</body>
</html>

					