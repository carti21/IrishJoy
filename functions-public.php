<?php 

	include("config.php");

	/**
	 * Function to show meta_tags in the beggining of HTML
	 */
	function show_meta_tags(){
		?>
		<META name="generator" content="<?php echo MAIN_URL; ?>">
		<meta name="description" content="Photography, Images, Design, Architecture, Interior, Design, Cars, Gallery, Girls, Landscape">
		<meta name="keywords" content="Photography, Images, Design, Architecture, Interior, Design, Cars, Gallery, Girls, Landscape">
		<meta name="author" content="<?php echo MAIN_URL; ?>">
		<meta http-equiv="Content-Type" content="text/html"; charset="ISO-8859-1" >
		<?php
	}

	/**
	 * Function to show the footer tags for the pages
	 */
	function show_footer_requires(){
		?>
				</body>  
			</html>
		
		<?php
	}

    /**
     * Function to show all the Categories on the Right Main Menu
     * @param  $mysql_conn Mysql Connection
     */
	function show_main_menu($mysql_conn){
		$query = "SELECT id, category_name FROM categories ORDER BY category_name";
        $result = mysqli_query($mysql_conn, $query);

        $categories_array = array();
		while($row = mysqli_fetch_array($result)){
			$categories_array[$row['id']] = $row['category_name'];
		}

		foreach($categories_array as $category_id => $category_name){
		?>
			<div class="menu_items">
				<a href="<?php echo MAIN_URL; ?>?category-id=<?php echo $category_id; ?>">
					<?php echo $category_name; ?>
				</a>
			</div>
		<?php			
		} 
	}	

	/**
	 * Function to show the images in the main page.
	 * The Images are displayed in two column from 7 images each.
	 * @param  $mysql_conn MySql Connection
	 */
	function show_images($mysql_conn){

		if( isset($_GET['page']) && $_GET['page'] >1 ){
			$page = $_GET['page']; 
		} else {
			$page = 1;
		}

		if( isset($_GET['category-id']) && $_GET['category-id'] >1 ){
			$cat_query_string = "AND category_id = " . $_GET['category-id'];
		}

		$min = ($page - 1) * 14; 

		$query_select_img = "SELECT id, image_name FROM posts WHERE status = 1 $cat_query_string ORDER BY created_at DESC LIMIT 14 OFFSET $min";
		$result_img = mysqli_query($mysql_conn, $query_select_img);

		?>
		<div class="content_img_left">
			<?php
				$i=0; 
				while($row_img = mysqli_fetch_array($result_img)){
					if($row_img['image_name']!=''){
						$img_path = MAIN_URL . "uploads/".$row_img['image_name'];
						$permalink = "Permalink: ( " . MAIN_URL . "view-image.php?post-id=". $row_img['id'] . ")";
						?>
						<a href="view-image.php?post-id=<?php echo  $row_img['id'] ?>" >
							<img class="content_img_left" src= "<?php echo $img_path; ?>" title="<?php echo $permalink; ?>" />
						</a>
						<?php
					}

					if($i == 6){
						?>
						</div>
						<div class="content_img_right">
						<?php
					}
					$i++;
				}
			?>
		</div>
		<?php
	}

	/**
	 * Function to display the pagination in the footer
	 */
	function pagination(){

		echo"<p>";
		if ( isset($_GET['page']) && $_GET['page'] > 1 ){
			$prev = $_GET['page'] - 1;
			$next = $_GET['page'] + 1;

			?>
			<a href="<?php echo MAIN_URL . "?page=".$prev ?>"> Prev Page </a>
				&nbsp; &nbsp; &nbsp;
			<a href="<?php echo MAIN_URL . "?page=".$next ?>"> Next Page </a>

			<?php
		} else {
			?>
			<a> Prev Page </a>
				&nbsp; &nbsp; &nbsp;
			<a href="./<?php echo "?page=2"; ?>"> Next Page </a>
			<?php
		}
		echo"</p>";
	}
	  
	/**
	 * Function to show a single image by id
	 * Also increments the number of views in the database
	 * @param  $mysql_conn MySql connection
	 */
	function show_single_image($mysql_conn){
		$post_id = $_GET['post-id']; 

		$query_select_posts = "SELECT id, image_name FROM posts WHERE id = $post_id"; 
		$result_posts = mysqli_query($mysql_conn, $query_select_posts);
		$row_post = mysqli_fetch_array($result_posts);
		
		$img_path = UPLOADS_URL . $row_post['image_name']; 
		?>
			<img class="img_view_full" src="<?php echo $img_path; ?>" />
		<?php

		$query_select_post_views= "SELECT views FROM posts WHERE id= $post_id" ;
		$result_fetch = mysqli_query($mysql_conn,$query_select_post_views);
		$result_select_postviews = mysqli_fetch_array($result_fetch);
		$views = $result_select_postviews['views'] + 1;

		$query_update=("UPDATE posts SET views=$views WHERE id='$post_id'");

		$result_update_postcounter = mysqli_query($mysql_conn,$query_update) ;
	}

	/**
	 * Function to get the category name by ID of the Post
	 * @param  $mysql_conn MySql Connection
	 * @param  int $post_id The id of the Post
	 * @return string Category Name
	 */
	function get_category_by_id($mysql_conn,$post_id) {

		$query_select_post_cat= "SELECT category_id FROM posts WHERE id = $post_id" ;
		$result_fetch = mysqli_query($mysql_conn,$query_select_post_cat);
		$result_select_postcat = mysqli_fetch_array($result_fetch);
		
		return $result_select_postcat['category_id']; 
	}
