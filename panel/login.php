<?php 
	include 'includes/db_connect.php';
	include 'includes/functions.php';
	
	sec_session_start();
	if(login_check($mysqli) == true)
	 {
	   // Add your protected page content here!
	   header('Location: ./panel.php');
	 } 
?>
<html>
<head>
<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="css/login.css" />		
		<link rel="icon" href="http://irishjoy.com/panel/images/favicon.png" type="image/x-icon"> 
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
	<p>Enter your email addres and password to login: Go to back to <a href="http://irishjoy.com">Main Page</a> </p>
	<form action="process_login.php" method="post" name="login_form">
   Email: <input type="text" name="email" />
   Password: <input type="password" name="p" id="password" />
   <button class="login" value="Login"  onclick="formhash(this.form, this.form.password);">Login</button>
</form>

					
	</div>
</div>		

	
</body>	
</html>