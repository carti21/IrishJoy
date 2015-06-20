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
		<title>Add new member</title>
		<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
		<link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon"> 
				<script type="text/javascript" src="includes/sha512.js"></script>
				<script type="text/javascript" src="includes/forms.js"></script>
				
	</head>
<body>

			<div id="head">
				<div id="right_head_bar"> </div>
			</div>
 		
 			<div id="container">
		 		<div id="content">
					<div id="members_new">
							
							 
							 <p><b>Add a new Member</p></b></br>
						<form method="post" action="" name="add_member">
							<label>Username: </label>
						    <input type="text" name="name" value="" /> </br></br>
							
							<label>Password: </label>
						    <input type="password" name="p" id="password" /></br></br>
						    
						    <label>Email: </label>
						    <input type="text" name="email" value="" /></br></br></br>
						    
						    <div style="float:right;">
						    	<button class="content" onclick="formhash(this.form, this.form.password);">Add member</button>
						    </div>	
						    <div style="float:left; margin-right: 5px;">
						    	<a href="members.php" "target="__blank">Cancel</a>
						    </div>	
						</form>
						<?php
						if( ($_POST['name']) && ($_POST['p']) &&($_POST['email']) )
						{
							add_member($mysqli, $_POST['name'], $_POST['p'], $_POST['email']);
							
							header('Location: ./members.php');
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
 
</body>
</html>

					