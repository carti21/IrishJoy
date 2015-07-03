<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Administration Panel</title>
		<?php header_requires(); ?>
		<script>
			$("#custom_menu_button").ready(function(){
			  $("#custom_menu1").hide();
			    $("#custom_menu2").hide();
			    $("#custom_menu3").hide();
			  $("#custom_menu_button").click(function(){
			    $("#custom_menu1").fadeToggle(400);
			    $("#custom_menu2").fadeToggle(600);
			    $("#custom_menu3").fadeToggle(800);
			  });
			});
		</script>
	</head>
	<body>
		<div class="head">	 
			<?php head_custom_menu(); ?>	
		</div>
 		<div class="container">
 			<div class="sidebar_right">
				<div class="menu_bar">
					<?php show_panel() ?>
				</div>
			</div>
		 	<div class="content">
		 		<div>
		 			<b>Quick Tasks</b>
		 		</div></br>
		 		<div class="tasks"> 
	                <a href="post-new.php" >
			 			<div class="quick_tasks"><div class="quick_tasks_items">+ Add Post</div></div>
			 		</a>
			 		<a href="members-new.php" >
	               		<div class="quick_tasks"><div class="quick_tasks_items">+ Add member</div></div>
	                </a>
	                <a href="members-login-traces.php" >
			 			<div class="quick_tasks"><div class="quick_tasks_items">View Login Traces</div></div>
			 		</a>
		 		</div>
		 		<div class="tasks">
			 		<a href="posts-database.php" >
				 		<div class="quick_tasks">
				 			<div class="quick_tasks_items">View all posts</div>
				 		</div>
			 		</a>
			 		<a href="contact.php" >
			 			<div class="quick_tasks">
			 				<div class="quick_tasks_items">Contact to Administrators</div>
			 			</div>
			 		</a>
	                <a href="members-login-attempts.php">
			 			<div class="quick_tasks">
			 				<div class="quick_tasks_items">Error Login Attempts</div>
			 			</div>
			 		</a>
		 		</div>

                <?php show_statistics($mysqli); ?>
		 		
		 	</div>		 		
 		</div>		
	</body>
</html>