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
		<div id="head">
			<div id="right_head_bar"> </div>
		</div>
		<div id="container">
 			<div id="members_new" style="width: 350px">
				<div>	 
					<form action="" method="post"></br></br>
						<label>New Category Name</label>
						<input type="text" name="new_category" />  </br></br></br>
						<div style="float:right;">
							<button class="content" name="add_category" value="Add Category"> Add Category </button>
						</div>	
						<div style="float:left; margin-right: 5px;">
							<a href="categories.php" target="__blank">Go back to category</a>
						</div>	
					</form>
						<?php
							if($_POST['new_category'])
							{
								new_category($mysqli,$_POST['new_category']);
							}
						?>
	    		</div>
	 		</div>
			<div id="sidebar_right">
				<div id="menu_bar">
					<?php show_panel() ?>
				</div>
			</div>
		</div>
		<div id="footer" > <div style="margin-left:580px; margin-top:0px"> &copy; www.irishjoy.flivetech.com 2013</div></div>
	</body>
</html>

					