<?php
require_once('functions-admin.php');

sec_session_start();
if (login_check($mysql_conn) == true) {
    header('Location: ./index.php');
}
?>

    <html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="css/admin-style.css"/>
        <link rel="icon" href="<?= MAIN_URL ?>admin/super/images/favicon.png" type="image/x-icon">
    </head>
<body>
<div class="container-login">
    <?php
    if (isset($_GET['error'])) {
        echo "<script>
				 	 alert('ERROR: Invalid username or password. Please try again. ');
					 window.location.href='login.php';
				  		</script>";
    }
    ?>
    <div id="login_box">
        <div id="login">
            <form action="process-login.php" method="post" name="login_form">
                <label> Email:
                    <input type="text" name="email"/><br> <br>
                </label>
                <label> Password:
                    <input type="password" name="password"/>
                </label>
                <button class="login" value="Login">Login</button>
            </form>
            <p> Close and go to back to <a href="<?php echo MAIN_URL; ?>">Main Page</a></p>
        </div>
    </div>
</div>
<?php footer_requires($mysql_conn); ?>