<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Database</title>
		<link rel="icon" href="<?= MAIN_URL ?>panel/super/images/database.png" type="image/x-icon"> 
		<link rel="stylesheet" href="css/post_database_table.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" type="text/css" href="css/css_panel.css" />
		<script type="text/javascript" src="js/jquery-latest.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
		<script type="text/javascript" src="js/docs.js"></script>
		<script type="text/javascript">
			$(function() {
				$("table")
					.tablesorter({widthFixed: true, widgets: ['zebra']})
					.tablesorterPager({container: $("#pager")});
			});
		</script>

	    
	</head>
	<body style="background-color:#eee;">
		<div id="head" style="height:35px; background-color:#336699; margin-bottom:10px;"> 
			<div style="float:left; padding-left:40px; text-shadow: 0px 0px 6px rgba(255,255,255,0.7);padding-top: 7px;">
				<a style="color:#fff; text-decoration:none;" href="<?= PANEL_URL ?>panel.php">
						<img style=" width:15px; height:auto; margin-bottom:-3px; margin-right:3px;"src="images/white_left_arrow.png">Back
				</a>
			</div>
			<div style="color:#FDFDFD; float:right; margin-right: 20px; margin-top: 7px; text-shadow: 0px 0px 6px rgba(255,255,255,0.7);">
				
				<?php 
					date_default_timezone_set('Europe/Berlin');
					echo date('l,  d.m.Y - H:i '); 
				?> 
			</div> 
		</div>
		<div id="container" style="width:970; min-height: 600px; background-color:#eee; margin: auto;">
	 		<div id="content" style="width:970; margin-top: 0px;">
				<?php  show_posts_database($mysqli) ?>				

				<div id="pager" class="pager" style="margin-top:15px; margin-left:310px;">
					<form>
						<img src="images/first.png" title="Newer Posts" class="first" style="width:20px; height:auto;"/>
						<img src="images/previous.png" style="width:20px; height:auto;" class="prev"/>
						<input type="text" class="pagedisplay" style="float:center; height:20px; margin-top: -5px; text-align: center; margin-left:5px;"/>
						<img src="images/next.png" style="width:20px; height:auto;" class="next"/>
						<img src="images/last.png" title="Older Posts" class="last" style="width:20px; height:auto;" />
	
						<div style="float:right">
							<select class="pagesize">
								<option selected="selected"  value="30" style="display:none;">Rows</option>
								<option value="10">10</option>
								<option value="20">20</option>
								<option value="40">40</option>
								<option  value="50">50</option>
								<option  value="100">100</option>
							</select>
						</div>
					</form>
				</div>		 	
			</div>		
		</div>
	</body>
</html>