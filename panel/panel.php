<?php 
include 'includes/db_connect.php';
include 'includes/functions.php';
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
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administration Panel</title>
<link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon"> 
	<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
<div id="head">	 <?php head_custom_menu(); ?>	</div>
		


	
	
</div>
 		
 		<div id="container">
 			<div id="sidebar_right">
					
					<div id="menu_bar">
						<?php show_panel() ?>
					

					</div>
				
				</div>
		 		<div id="content">
		 		
		 		<div><b>Quick Tasks</b></div></br>
		 		<div id="tasks" style="float:left">
		 		
                <a href="post-new.php" >
		 		<div id="quick_tasks"><div id="quick_tasks_items">+ Add Post</div></div></a>
		 		<a href="members-new.php" >
                <div id="quick_tasks"><div id="quick_tasks_items">+ Add member</div></div></a>
                <a href="members-login-traces.php" >
		 		<div id="quick_tasks"><div id="quick_tasks_items">View Login Traces</div></div></a>
		 		</div>
		 		<div id="tasks"  style="float:right">
		 		<a href="posts-database.php" >
		 		<div id="quick_tasks"><div id="quick_tasks_items">View all posts</div></div></a>
		 		<a href="contact.php" >
		 		<div id="quick_tasks"><div id="quick_tasks_items">Contact to Administrators</div></div></a>
                <a href="members-login-attempts.php" >
		 		<div id="quick_tasks"><div id="quick_tasks_items">Error Login Attempts</div></div></a>
		 		</div>
                                 <?php show_statistics($mysqli); ?>
		 		

		 		</div>
		 		
				
 
 		</div>
 		
 
 		
</body>

</html>