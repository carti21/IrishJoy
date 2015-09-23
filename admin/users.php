<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }

	if( isset($_GET['del']) && $_GET['del']==1 )
	{
		if($_GET['id']>0){
			delete_user($mysql_conn,$_GET['id']);
			header("Location: users.php"); 
		}
	}
 
	if( isset($_GET['edit']) && $_GET['edit']==1 ){
		header("Location: users-edit.php?id=".$_GET['id']);
	}  
?>

<html>
	<head>
		<title>Users</title>
		<?php header_requires(); ?>
	</head>
	<body>
		<div class="head"></div>
		<div class="container">
	 		<div class="content">
	 			<div> <?php show_user_menu(); ?> </div>									 
				<?php show_all_users($mysql_conn); ?>
	 		</div>	 		
			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_admin_menu(); ?>
				</div>
			</div>
		</div>
	<?php footer_requires($mysql_conn); ?>

					