<?php 
	include 'includes/db_connect.php';
	include 'includes/functions.php';
	
	sec_session_start();
	if(login_check($mysqli) == true)
	 {
	   // Add your protected page content here!
	   header('Location: ./login.php');
	 } 
?>
<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="css/login.css" />		
		<link rel="icon" href="<?= MAIN_URL ?>panel/super/images/favicon.png" type="image/x-icon"> 
	</head>
	<body OnLoad="document.login_form.email.focus();">
		<script type="text/javascript" src="includes/sha512.js"></script>
		<script type="text/javascript" src="includes/forms.js"></script>
		<?php
			if(isset($_GET['error'])) {
			  	echo "<script>
			 	 alert('ERROR: Invalid username or password. Please try again. ');
				 window.location.href='login.php';
			  		</script>";	
			}
		?>
		<div id="login_box">
			<div id="login">
				<form action="process_login.php" method="post" name="login_form">
					Email: <input type="text" name="email" style="margin-left:27px;"/></br> </br> 
					Password: <input type="password" name="p" id="password" />
					<button class="login" value="Login"  onclick="formhash(this.form, this.form.password);">Login</button>
				</form>
				<p style="margin-left:80px;"> Close and go to back to <a href="http://irishjoy.flivetech.com">Main Page</a> </p>					
			</div>
		</div>		
	</body>	
</html>