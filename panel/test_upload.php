<?php 
	include 'includes/db_connect.php';
	include 'includes/functions.php';
	error_reporting(0); // jane gabime qe duhen pare ne fund !!! 
		// Include database connection and functions here.
	sec_session_start();
	if(login_check($mysqli) == true) {
	 
	   // Add your protected page content here!
	 
	} else {
	   header('Location: ./login.php');
	}

 ?>


<html>
	<head>
		<title>Upload test</title>
		<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
	</head>
<body>

			<div id="head">
				<div id="right_head_bar"> </div>
			</div>
 		
 			<div id="container">
		 		<div id="content">
		 			
		 			<h2>Ngarko Skedare</h2>
						<form method="post" action="" enctype="multipart/form-data">
							<label>Zgjidh Skedarin</label>
						    <input type="file" name="skedar" size="40">
						    <button type="submit" class="content"> Ngarko Skedarin</button>
						</form>
						<div >
						<?php
						if(isset($_FILES['skedar']['name'])){
						$name = upload_image($_FILES['skedar']['name'], $_FILES['skedar']['size'], $_FILES['skedar']['tmp_name']) ;
							echo "$name";
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
 
 		<div id="footer"> </div>

</body>
</html>