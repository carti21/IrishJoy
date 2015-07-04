<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
	<head>
		<title>Login Traces</title>
		<?php header_requires(); ?>
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

			<div id="head">
				

		    		</div>
			</div>
 		
 			<div id="container">
		 		<div id="content">
					<div id="content"> 
						<div><?php show_member_menu(); ?> </div>
					
							 
					<?php show_member_login_traces($mysqli); ?>
		    		
		    		<div id="pager" class="pager" style="margin-top:15px; margin-left:120px;">
	<form>
		<img src="images/first.png" title="First Page" class="first" style="width:20px; height:auto;"/>
		<img src="images/previous.png" style="width:20px; height:auto;" class="prev" />
		<input type="text" class="pagedisplay" 
			style="float:center; height:20px; margin-top: -5px; text-align: center; margin-left:5px;"/>
		<img src="images/next.png" style="width:20px; height:auto;" class="next"/>
		<img src="images/last.png" title="Last Page" class="last" style="width:20px; height:auto;" />
		
		<div style="float:right"><select class="pagesize">
			<option selected="selected"  value="20" style="display:none;">Rows</option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option  value="50">50</option>
			<option  value="100">100</option>
			
		</select> </div>
	</form>
</div>
		    		
		    		
		    		
		    		</div>
		 			
		 			
		 		</div>
		 		
				<div id="sidebar_right">
					<div id="menu_bar">
						<?php show_panel() ?>
					</div>
				</div>
 
 		</div>
 
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
_uacct = "UA-2189649-2";
urchinTracker();
</script>
</body>
</html>

					