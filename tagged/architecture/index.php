<?php 
	$root = realpath(__DIR__ . '/../..');
	require_once("$root/includes/functions-public.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sq">
	<head>
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Architecture - IrishJoy.com</title>
		<link rel="stylesheet" type="text/css" href="<?php echo MAIN_URL; ?>css/public-style.css" />
		<link rel="icon" href="<?php echo MAIN_URL; ?>images/favicon.png" type="image/x-icon"> 
	</head>
	<body>
		<div class="head">
			<div style="margin: 0 auto; position: relative; width:40%; padding-top: 30px;">
				<a href="<?php echo MAIN_URL; ?>">
				<img src="<?php echo MAIN_URL; ?>images/head_logo.jpg">
				</a>
			</div>	
		</div>	
		<div class="container">
			<div class="sidebar_right">
				<div class="ad_box"> <img src="<?php echo MAIN_URL; ?>images/ads.png" alt="Advertising" ></div>
				<div class="ad_bottom">
					<div style="margin-top:15px;"><a>ADVERTISE HERE</a></div>
				</div>
				<div class="before_menu">
					<?php // <img src="images/social_box.jpg" alt="Social box" > ?>
				</div>
				<div class="menu_bar">
					<?php show_main_menu() ?>
				</div>
			</div>
	 		<div class="content">
	 			<div class="content_img_left">
		 			<?php 
		 				$cat_name = "architecture" ;
		 				if(isset($_GET['jump'])){
		 					$page = $_GET['jump'];	
		 				} else {
		 					$page = 1;
		 				}

		 				$start_left="$page"*7; 
						show_left_col_images_category($mysqli,$cat_name,$start_left);
		 			
		 			?> 
	 			</div> 
	 			<div class="content_img_right"> 
	 			
	 			<?php 
	 				$cat_name="architecture";
	 			
	 				$start_right=(($page+1)*7); 
					show_right_col_images_category($mysqli,$cat_name,$start_right);
	 			
	 			?>
	 			</div>
	 		</div>
		</div>
		<div class="footer"> 
			<p>
			<?php $page=$page-2; echo'<a href=' . MAIN_URL. 'tagged/architecture?jump='.$page.' >'?> Prev Page</a> 
			<?php echo"&nbsp; &nbsp; &nbsp;"?>
			<?php $page=$page+2; echo'<a href=' . MAIN_URL. 'tagged/architecture?jump='.$page.' >'?> Next Page</a> 
			</p>	
		</div>
	</body>
</html>