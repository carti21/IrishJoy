<?php
    require_once('functions.php');

    sec_session_start();
    if(login_check($mysqli) == false){
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Database</title>
		<?php header_requires(); ?>
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
	<body>
		<div class="posts_database_head"> 
			<div class="posts_database_left_box">
				<a style="color:#fff; text-decoration:none;" href="<?= PANEL_URL ?>panel.php">
						<img style=" width:15px; height:auto; margin-bottom:-3px; margin-right:3px;" src="images/white_left_arrow.png">Back
				</a>
			</div>
			<div class="posts_database_right_box">
				
				<?php 
					date_default_timezone_set('Europe/Berlin');
					echo date('l,  d.m.Y - H:i '); 
				?> 
			</div> 
		</div>
		<div id="container" style="width:970; min-height: 600px; background-color:#eee; margin: auto;">
	 		<div id="posts_database_content">
				<?php  show_posts_database($mysqli) ?>				

				<div id="pager" class="pager" style="margin-top:15px; margin-left:310px;">
					<form>
						<img src="images/first.png" title="Newer Posts" class="first" style="width:20px; height:auto;"/>
						<img src="images/previous.png" style="width:20px; height:auto;" class="prev"/>
						<input type="text" class="pagedisplay" style="height:20px; margin-top: -5px; text-align: center; margin-left:5px;"/>
						<img src="images/next.png" style="width:20px; height:auto;" class="next"/>
						<img src="images/last.png" title="Older Posts" class="last" style="width:20px; height:auto;" />
	
						<div class="pull-right">
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