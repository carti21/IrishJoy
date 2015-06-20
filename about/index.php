<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include "$root/includes/functions_public.php";
	include "$root/includes/db_connect.php";  
?>
<html>
<head>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>About - IrishJoy.com - Inspiration Is Everywhere</title>
<link rel="stylesheet" type="text/css" href="http://irishjoy.com//css/css_public.css" />
<link rel="icon" href="http://irishjoy.com/images/favicon.png" type="image/x-icon"> 
</head>
 


<body>
<div id="head">
	<div style="margin: 0 auto; position: relative; width:40%; padding-top: 30px;">
	<a href="http://irishjoy.com">
	<img src="http://irishjoy.com/images/head_logo.jpg">
	</a>
	</div>
</div>
 		
 		<div id="container">
		 		<div id="sidebar_right">
					<div id="ad_box"> <img src="http://irishjoy.com/images/ads.png" alt="Advertising" ></div>
					<div id="ad_bottom">
						<div style="margin-top:15px;"><a>ADVERTISE HERE</a></div>
					</div>
					<div id="before_menu">
						<div style="margin-left:40px; margin-top: 10px; overflow-x: hidden;">
						<div class="fb-like-box" data-href="http://www.facebook.com/irishjoycom" 
						data-colorscheme="light" data-show-faces="false" 
						data-header="true" data-stream="false" data-show-border="true"></div>
						 
						<div style="margin-left:7px;" class="fb-follow" data-href="http://www.facebook.com/irishjoycom" 
						data-colorscheme="light" data-layout="button_count" data-show-faces="true"></div>
					</div>
					</div>
					<div id="menu_bar">
						
						<?php show_menu() ?>
						
					</div>
				</div>
		 		
		 		<div id="content">
		 			<p>IrishJoy.com - Inspiration Is Everywhere</p>
		 			
		 			<p>Irishjoy.com is a high quality photo-blog. You can contact with our team: 
		 				
		 				</br>ardit@irishjoy.com</p>
		 			
		

		 			</div>
		

		 			</div>
		 			
		 			
		 			
		 			
	
		 			
		 		</div>
		 		
		 		
 
 		</div>
 
 		<div id="footer"> 
 		<p>
 				<?php $page=$_GET['jump']; $page=$page-2; echo"<a href=\"http://irishjoy.com/tagged/cars?jump=$page\" >"?> Prev Page</a> 
 				<?php echo"&nbsp; &nbsp; &nbsp;"?>
 				<?php $page=$_GET['jump']; $page=$page+2; echo"<a href=\"http://irishjoy.com/tagged/cars?jump=$page\" >"?> Next Page</a> 
 				</p>		
 			
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