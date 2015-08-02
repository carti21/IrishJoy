<?php 
	require_once('functions-public.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sq">
<html>
	<head>
		<title>IrishJoy.com - Inspiration Is Everywhere.</title>
		<?php show_meta_tags(); ?>
		<link rel="stylesheet" type="text/css" href="css/public-style.css" />
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
				<div class="ad_box">
					<a href="#"> 
						<img src="images/ads.png">
					</a>
				</div>
				<div class="ad_bottom">
					<div style="margin-top:15px;">
						<a href"http://www.intolaravel.com/">Our Partners</a>
					</div>
				</div>
				<div class="before_menu">
					<!-- Social Media Buttons goes here -->
				</div>
				<div class="menu_bar">
					<?php show_main_menu($mysqli); ?> 
				</div>
			</div>	 		
	 		<div class="content">
				<div class="content_img_left">
		 			<?php 

		 				if(isset($_GET['page'])){
		 					$page = $_GET['page'];
		 				} else {
		 					$page = 0;
		 				}

		 				$start_left="$page"*7; 
						show_left_col_images_by_category($mysqli, $start_left, $_GET['cat_id']);
		 			
		 			?> 
	 			</div> 
	 			<div class="content_img_right"> 
		 			<?php 
		 				$start_right=(($page+1)*7); 
						show_right_col_images_by_category($mysqli, $start_right, $_GET['cat_id'])
		 			
		 			?>
	 			</div>
	 		</div>			
	 	</div>
		<div class="footer"> 
			<p>
				<?php 
					if(isset($_GET['page']))
					{
						if($_GET['page']!=0){
							$page=$_GET['page']; $page=$page-2; 
							?>
							<a href="?page=<?php echo $page; ?>"> Prev Page </a>
							<?php
						} else {
							?>
							<a href="<?php echo MAIN_URL; ?>"> Prev Page </a> 
							<?php
						}
					} else {
						?>
						<a href="<?php echo MAIN_URL; ?>"> Prev Page </a>
						<?php
					}
				
					echo"&nbsp; &nbsp; &nbsp;";
				
					if(isset($_GET['page'])){
						$page=$_GET['page']; 
						$page=$page+2; 
						?>
						<a href="<?php echo MAIN_URL; ?>?page=$page"> Next Page</a>
						<?php
					}
				
					else { 
						echo"<a href=\"http://irishjoy.flivetech.com?page=2\"> Next Page</a> ";
					}
				?>
				
			</p>
			<div class="copyright"> 
				&copy; www.irishjoy.com 2014 &nbsp;&nbsp;&nbsp; 
				<a target="_blank" href="http://facebook.com/irishjoycom"> www.facebook.com/irishjoycom</a>
			</div>
	</div>
	</body>  
</html>

		