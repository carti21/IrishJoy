<?php 
	require_once('functions.php');
	
	sec_session_start();
	if(login_check($mysqli) == true){
	   header('Location: ./panel.php');
	}
?>

<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="css/login.css" />		
		<link rel="icon" href="<?= MAIN_URL ?>panel/super/images/favicon.png" type="image/x-icon"> 
	</head>
	<body>
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
				<form action="process-login.php" method="post" name="login_form">
					Email: <input type="text" name="email"/></br> </br> 
					Password: <input type="password" name="password"/>
					<button class="login" value="Login">Login</button>
				</form>
				<p> Close and go to back to <a href="<?php echo MAIN_URL; ?>">Main Page</a> </p>					
			</div>
		</div>		
	</body>	
</html>