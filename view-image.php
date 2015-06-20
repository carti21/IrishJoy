<?php 
	include 'includes/functions_public.php';
	include 'includes/db_connect.php';

	$id=$_GET['p_id']; 
	$cat=get_cat($mysqli,$id);
	$cat=strtolower($cat);
?>
<html>
<head>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IrishJoy.com - <?php echo"#";echo"$cat"?> - Inspiration Is Everywhere</title>  
<?php show_meta_tags(); ?>
<link rel="stylesheet" type="text/css" href="css/css_public.css" />
<link rel="icon" href="http://irishjoy.flivetech.com/images/favicon.png" type="image/x-icon"> 

<!-- SEO Pack  -->
<link rel="author" href="irishjoy.flivetech.com" />
<meta name="description" content="<?php $title=get_post_title($mysqli,$id); echo"$title"; ?>" />

<meta name="keywords" content="<?php $title=get_post_title($mysqli,$id); echo"$title"; ?>" />

<link rel="canonical" href="http://irishjoy.flivetech.com/view-image.php?p_id=<?php echo"$id"?> " />
<!-- /all in one seo pack -->

</head>
 

 
<body>
	<div id="fb-root"></div>
<script src="http://irishjoy.flivetech.com/includes/facebook_js.js"></script>

<div id="head" >
	<div style="margin: 0 auto; position: relative; width:40%; padding-top: 30px;">
	<a href="http://irishjoy.flivetech.com">
	<img src="http://irishjoy.flivetech.com/images/head_logo.jpg">
	</a>
	</div>
	
</div>
	
</div>
 		
 		<div id="container"> 
 			
 			
		 		<div id="content">
		 			
		 			<?php 
			 			$id=$_GET['p_id']; 
						view_image($mysqli,$id);
						$a=get_numb_views($mysqli,$id);
						$a++;
						
						increment_numb_views($mysqli,$a,$id) 
						
		
		 			?>
						
						<div id="after_full_image">
						<div style="margin-top:9px; margin-left:15px;"
						class="fb-like" data-href="<?php echo"http://irishjoy.flivetech.com/view-image.php?p_id="."$id"?>" 
						data-colorscheme="light" data-layout="button_count" data-action="like" 
						data-show-faces="false" data-send="false"></div>
						</div>
						
						<div id="after_full_image">
							<div style="margin-top:18px; margin-left:15px;">
							<?php echo"<span>TAGS:<a href=\"tagged/"."$cat\">#$cat</a></span>"?></div>
						</div>
		 			</div>

				<div id="ad_box"><a href="http://www.flivetech.com/" target="_blank"> <img style="width:300px; height:auto;" src="images/flivetech.png"  alt="Flivetech.com - Flying Technology" ></a></div>
					<div id="ad_bottom">
						<div style="margin-top:15px;"><a href"http://www.flivetech.com/">Our Partners</a></div>
					</div>
					<div id="before_menu">
						<div style="margin-left:40px; margin-top: 10px; overflow-x: hidden;">
						<div class="fb-like-box" data-href="http://www.facebook.com/irishjoycom" 
						data-colorscheme="light" data-show-faces="false" 
						data-header="true" data-stream="false" data-show-border="true"></div>
						
						<div style="margin-left:7px;" class="fb-follow" data-href="http://www.facebook.com/irishjoycom" 
						data-colorscheme="light" data-layout="button_count" data-show-faces="true"></div>
					</div> </div>
					<div id="menu_bar">
						
						<?php show_menu() ?>
						
					</div>
				</div>  
 
 		</div>
 
 		<div id="footer" style="background-color:#383838;"> 
 			<div id="copyright">&copy; www.irishjoy.com 2014 &nbsp;&nbsp;&nbsp; <a target="_blank" href="http://facebook.com/irishjoycom"> www.facebook.com/irishjoycom</a></div>
 		
 			</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=196831577074570";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>