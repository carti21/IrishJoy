<?php 
	include 'includes/functions-public.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sq">
<html>
	<head>
		<title>IrishJoy.com - Inspiration Is Everywhere.</title>
		<?php show_meta_tags(); ?>
		<link rel="stylesheet" type="text/css" href="css/css_public.css" />
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
					<a href="http://www.flivetech.com/" target="_blank"> 
						<img style="width:250px; padding-left:20px; height:auto;" src="images/flivetech.png"  alt="Flivetech.com - Flying Technology">
					</a>
				</div>
				<div class="ad_bottom">
					<div style="margin-top:15px;">
						<a href"http://www.flivetech.com/">Our Partners</a>
					</div>
				</div>
				<div class="before_menu">
					<div style="margin-left:40px; margin-top: 10px; overflow-x: hidden;">
						<div class="fb-like-box" data-href="http://www.facebook.com/irishjoycom" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="false" data-show-border="true">
						</div>
						<div style="margin-left:7px;" class="fb-follow" data-href="http://www.facebook.com/irishjoycom" data-colorscheme="light" data-layout="button_count" data-show-faces="true">
						</div>
					</div> 
				</div>
				<div class="menu_bar">
					<?php show_main_menu(); ?> 
				</div>
			</div>	 		
	 		<div class="content">
				<div class="content_img_left">
		 			<?php 

		 				if(isset($_GET['jump'])){
		 					$page = $_GET['jump'];
		 				} else {
		 					$page = 1;
		 				}

		 				$start_left="$page"*7; 
						show_left_col_images($mysqli,$start_left);
		 			
		 			?> 
	 			</div> 
	 			<div class="content_img_right"> 
		 			<?php 

		 				$start_right=(($page+1)*7); 
						show_right_col_images($mysqli,$start_right);
		 			
		 			?>
	 			</div>
	 		</div>			
	 	</div>
		<div class="footer"> 
			<p>
				<?php 
					if(isset($_GET['jump']))
					{
						if($_GET['jump']!=0){
							$page=$_GET['jump']; $page=$page-2; 
							?>
							<a href="?jump=<?php echo $page; ?>"> Prev Page </a>
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
				
					if(isset($_GET['jump'])){
						$page=$_GET['jump']; 
						$page=$page+2; 
						?>
						<a href="<?php echo MAIN_URL; ?>?jump=$page"> Next Page</a>
						<?php
					}
				
					else { 
						echo"<a href=\"http://irishjoy.flivetech.com?jump=2\"> Next Page</a> ";
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

		