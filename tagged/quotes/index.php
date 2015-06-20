<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include "$root/includes/functions_public.php";
	include "$root/includes/db_connect.php";  
?>
<html>
<head>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quotes - IrishJoy.com</title>
<link rel="stylesheet" type="text/css" href="http://irishjoy.com//css/css_public.css" />
<link rel="icon" href="http://irishjoy.com/images/favicon.png" type="image/x-icon"> 
</head>
 


<body>
<div id="head">
	<?php // <img src="http://irishjoy.com/images/head_logo.jpg" alt="Social box" /> ?>
	<?php // <div id="right_head_bar"> </div> ?>
	
</div>
 		
 		<div id="container">
		 		<div id="sidebar_right">
					<div id="ad_box"> <img src="http://irishjoy.com/images/ads.png" alt="Advertising" ></div>
					<div id="ad_bottom">
						<div style="margin-top:15px;"><a>ADVERTISE HERE</a></div>
					</div>
					<div id="before_menu">
						<?php // <img src="images/social_box.jpg" alt="Social box" > ?>
					</div>
					<div id="menu_bar">
						
						<?php show_menu() ?>
						
					</div>
				</div>
		 		
		 		<div id="content">
		 			
		 			<div id="content_img_left">
		 			
		 			<?php 
		 				$cat_name="quotes";
		 				$page=$_GET['jump'];
		 				$start_left="$page"*7; 
						echo_img_left_category($mysqli,$cat_name,$start_left);
		 			
		 			?> 
		

		 			</div> 
		 			<div id="content_img_right"> 
		 			
		 			<?php 
		 				$cat_name="quotes";
		 				$page=$_GET['jump'];
		 				$start_right=(($page+1)*7); 
						echo_img_right_category($mysqli,$cat_name,$start_right);
		 			
		 			?>
		

		 			</div>
		

		 			</div>
		 			
		 			
		 			
		 			
	
		 			
		 		</div>
		 		
		 		
 
 		</div>
 
 		<div id="footer"> 
 		<p>
 				<?php $page=$_GET['jump']; $page=$page-2; echo"<a href=\"http://irishjoy.com/tagged/quotes?jump=$page\" >"?> Prev Page</a> 
 				<?php echo"&nbsp; &nbsp; &nbsp;"?>
 				<?php $page=$_GET['jump']; $page=$page+2; echo"<a href=\"http://irishjoy.com/tagged/quotes?jump=$page\" >"?> Next Page</a> 
 				</p>		
 			
 			</div>

</body>
</html>