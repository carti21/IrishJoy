<?php 

	include "config.php";

	function show_meta_tags(){
		?>
		<META name="generator" content="<?php echo MAIN_URL; ?>">
		<meta name="description" content="Photography, Images, Design, Architecture, Interior, Design, Cars, Gallery, Girls, Landscape">
		<meta name="keywords" content="Photography, Images, Design, Architecture, Interior, Design, Cars, Gallery, Girls, Landscape">
		<meta name="author" content="<?php echo MAIN_URL; ?>">
		<meta http-equiv="Content-Type" content="text/html"; charset="ISO-8859-1" >
		<?php
	}

	function show_main_menu(){	
		?>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/menswear"> menswear </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/design"> design </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/architecture"> architecture </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/cars"> cars </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/inspiration"> inspiration </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/girls"> girls </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/landscape"> landscape </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/interiors"> interior design </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/gears"> gears </a></div>
		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>tagged/photography"> photography </a></div>
		<?php			 
	}	
	  
	function show_left_col_images($mysqli,$start_left){

		$query_select_img = "SELECT id, post_photo_name FROM posts ORDER BY id DESC LIMIT " .$start_left. " , 7 ";
		$result_img = mysqli_query($mysqli, $query_select_img);	
		
		while($row_img = mysqli_fetch_array($result_img)){
			if($row_img['post_photo_name']!=''){
				$img_path = MAIN_URL . "uploads/".$row_img['post_photo_name'];
				?>
				<a href="view-image.php?p_id=<?php echo  $row_img['id'] ?>" >
					<img class="content_img_left" src= "<?php echo $img_path; ?>" title="Permalink: (<?php echo MAIN_URL; ?>view-image.php?p_id=<?php echo  $row_img['id']; ?>)">
				</a>
				<?php
			} 
		}
	}

	
	function show_right_col_images($mysqli,$start_right){

		$query_select_img = "SELECT id, post_photo_name FROM posts ORDER BY id DESC LIMIT ". $start_right. " , 7 "; 
		$result_img = mysqli_query($mysqli, $query_select_img);	
		
		while($row_img = mysqli_fetch_array($result_img)){

			if($row_img['post_photo_name']!=''){ 
				
				$img_path = UPLOADS_URL .$row_img['post_photo_name'];
				?>
				<a href="view-image.php?p_id=<?php echo $row_img['id']; ?>" >
					<img src= "<?php echo $img_path; ?>" title="Permalink: (irishjoy.com/view-image.php?p_id=<?php echo  $row_img['id']; ?>)" class="content_img_right" >
				</a>
				<?php	
			}
		}
	}

	function show_left_col_images_category($mysqli,$cat,$start_left){

		$query_select_img = "SELECT id, post_photo_name FROM post WHERE post_category= '$cat' ORDER BY id DESC LIMIT " .$start_left. ",7 "; 
		$result_img = mysqli_query($mysqli, $query_select_img);	
		 
		while($row_img = mysqli_fetch_array($result_img))
		{ 
			if($row_img['post_photo_name']!='')
			{
				$img_path = UPLOADS_URL .$row_img['post_photo_name'];
				?>
				<a href="view-image.php?p_id=<?php echo $row_img['id']; ?>" >
					<img class="content_img_left" src="<?php echo $img_path?>" />
				</a>
				<?php
			} 
		}
	}

	function show_right_col_images_category($mysqli,$cat,$start_right){

		$query_select_img = "SELECT id, post_photo_name FROM post WHERE post_category= '$cat' ORDER BY id DESC LIMIT ". $start_right. ",7 "; 
		$result_img = mysqli_query($mysqli, $query_select_img);	
		
		while($row_img = mysqli_fetch_array($result_img))
		{ 
			if($row_img['post_photo_name']!='')
			{
				$img_path = MAIN_URL . "tagged/".$row_img['post_photo_name'];
				?>
				<a href="view-image.php?p_id=<?php echo $row_img['id']; ?>" >
					<img class="content_img_left" src="<?php echo $img_path?>" />
				</a>
				<?php
			} 
		}
	}

	function show_single_image($mysqli,$post_id )
	{
		$query_select_posts = "SELECT id, post_photo_name FROM posts WHERE id = $post_id"; 
		$result_posts = mysqli_query($mysqli, $query_select_posts);	
		$row_post = mysqli_fetch_array($result_posts);
		
		$img_path = UPLOADS_URL . $row_post['post_photo_name']; 
		?>
			<img class="img_view_full" src="<?php echo $img_path; ?>" />
		<?php
	}

	function get_numb_views($mysqli,$post_id){

		$query_select_post_views= "SELECT post_views FROM posts WHERE id= $post_id" ;
		$result_fetch = mysqli_query($mysqli,$query_select_post_views);
		$result_select_postviews = mysqli_fetch_array($result_fetch);
		
		return $result_select_postviews['post_views']; 
	}

	function increment_numb_views($mysqli,$views_icr,$post_id){

		$query_update=("UPDATE posts SET post_views=$views_icr WHERE id='$post_id'");
		$result_update_postcounter = mysqli_query($mysqli,$query_update) ; 
	}

	function get_cat($mysqli,$post_id) {

		$query_select_post_cat= "SELECT category_id FROM posts WHERE id= $post_id" ;
		$result_fetch = mysqli_query($mysqli,$query_select_post_cat);
		$result_select_postcat = mysqli_fetch_array($result_fetch);
		
		return $result_select_postcat['category_id']; 
	}