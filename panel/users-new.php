<?php
    require_once('functions.php');

    sec_session_start();
    if (/*login_check($mysqli) == false*/1>2) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Add new user</title>
		<?php header_requires(); ?>
		<script type="text/javascript" src="includes/sha512.js"></script>
		<script type="text/javascript" src="includes/forms.js"></script>
	</head>
	<body>
	<div class="head">
		<div class="right_head_bar"> </div>
	</div>	
	<div class="container">
		<div class="content">
			<div class="users_new">
				<p><b>Add a new user</p></b></br>
				
				<form method="post" action="" name="add_user" method="POST">
					<label>Username: </label>
				    <input type="text" name="name" value=""> </br></br>
							
					<label>Password: </label>
				    <input type="password" name="password" value=""></br></br>

				    <label>Password Confirm: </label>
				    <input type="password" name="password_repeat" value=""></br></br>
						    
				    <label>Email: </label>
				    <input type="text" name="email" value=""></br></br></br>
						    
				    <div class="pull-right">
				    	<button type="submit" name="add_user" id="content" class="content_button">Add user</button>
				    </div>	
				    <div class="pull-right" style="margin-right: 5px;">
				    	<button href="users.php" target="__blank" class="content_button">Cancel</button>
				    </div>	
				</form>

				<?php
				if ( isset($_POST['add_user']) ){

					if( ($_POST['name']) && ($_POST['password']) &&($_POST['email']) )
					{
						add_user($mysqli, $_POST['name'], $_POST['password'], $_POST['password_repeat'], $_POST['email']);
						
						header('Location: ./users.php');
					}
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

					