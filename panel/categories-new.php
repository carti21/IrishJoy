<?php 
include 'includes/db_connect.php';
include 'includes/functions.php';
error_reporting(0); // jane gabime qe duhen pare ne fund !!! 
	// Include database connection and functions here.
sec_session_start();
if(login_check($mysqli) == true) {
 
   // Add your protected page content here!
 
} else {
   header('Location: ./');
}

 ?>

<html>
	<head>
		<title>Add a new Categorie</title>
		<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
		<link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon"> 
	</head>
<body>

			<div id="head">
				<div id="right_head_bar"> </div>
			</div>
 		
 			<div id="container">
		 		<div id="members_new" style="width: 350px"> <?php //perdoret divi i member qe te marre ccs per inputin ?>
					<div>
							 
							 <form action="" method="post"></br></br>
								<label>New Category Name</label>
								<input type="text" name="new_category" />  </br></br></br>
								
								<div style="float:right;">
									<button class="content" name="add_category" value="Add Category"> Add Category </button>
								</div>	
								<div style="float:left; margin-right: 5px;">
						    	<label></label><a href="categories.php" "target="__blank">Go back to category</a> </label>
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

					