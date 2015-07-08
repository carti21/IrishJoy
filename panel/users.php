<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }

	if( isset($_GET['del']) && $_GET['del']==1 )
	{
		if($_GET['id']>0)
		{
			delete_user($mysqli,$_GET['id']);
			header("Location: users.php"); 
		}
	}
 
	if( isset($_GET['edit']) && $_GET['edit']==1 )
	{
		header("Location: users-edit.php?id=".$_GET['id']);
	}  
?>

<html>
	<head>
		<title>Users</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"> <?php head_custom_menu(); ?> </div>
		<div class="container">
	 		<div class="content">
	 			<div> <?php show_user_menu(); ?> </div>									 
				<?php show_users($mysqli); ?>	 			
	 		</div>	 		
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_panel() ?>
				</div>
			</div>
		</div>
	</body>
</html>

					