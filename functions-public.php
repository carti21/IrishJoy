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

	 /**
     * Get all Categoris to an array
     * @param  $mysqli MySql Connection
     * @return array $categories_array [id]=>[category_name] array with
     * all teh Categories. Mostly used on dropdown select of categories
     */
    function get_categories_array($mysqli){
        $query = "SELECT id, category_name FROM categories ORDER BY category_name ";
        $result = mysqli_query($mysqli, $query);

        $categories_array = array();
        while($row = mysqli_fetch_array($result)){
          $categories_array[$row['id']] = $row['category_name'];
        }

        return $categories_array;
    }

	function show_main_menu($mysqli){	
		$categories_array = get_categories_array($mysqli);
		foreach($categories_array as $category_id => $category_name){
		?>

		<div class="menu_items"><a href="<?php echo MAIN_URL; ?>categories.php?cat_id=<?php echo $category_id; ?>"><?php echo $category_name; ?></a></div>
		
		<?php			
		} 
	}	
	  
	function show_left_col_images($mysqli,$start_left){

		$query_select_img = "SELECT id, image_name FROM posts WHERE status = 1 ORDER BY id DESC LIMIT " .$start_left. " , 7 ";
		$result_img = mysqli_query($mysqli, $query_select_img);	
		
		while($row_img = mysqli_fetch_array($result_img)){
			if($row_img['image_name']!=''){
				$img_path = MAIN_URL . "uploads/".$row_img['image_name'];
				?>
				<a href="view-image.php?p_id=<?php echo  $row_img['id'] ?>" >
					<img class="content_img_left" src= "<?php echo $img_path; ?>" title="Permalink: (<?php echo MAIN_URL; ?>view-image.php?p_id=<?php echo  $row_img['id']; ?>)">
				</a>
				<?php
			} 
		}
	}

	
	function show_right_col_images($mysqli,$start_right){

		$query_select_img = "SELECT id, image_name FROM posts WHERE status = 1 ORDER BY id DESC LIMIT ". $start_right. " , 7 "; 
		$result_img = mysqli_query($mysqli, $query_select_img);	
		
		while($row_img = mysqli_fetch_array($result_img)){

			if($row_img['image_name']!=''){ 
				
				$img_path = UPLOADS_URL .$row_img['image_name'];
				?>
				<a href="view-image.php?p_id=<?php echo $row_img['id']; ?>" >
					<img src= "<?php echo $img_path; ?>" title="Permalink: (irishjoy.com/view-image.php?p_id=<?php echo  $row_img['id']; ?>)" class="content_img_right" >
				</a>
				<?php	
			}
		}
	}

	function show_left_col_images_category($mysqli,$cat,$start_left){

		$query_select_img = "SELECT id, image_name FROM post WHERE post_category= '$cat' ORDER BY id DESC LIMIT " .$start_left. ",7 "; 
		$result_img = mysqli_query($mysqli, $query_select_img);	
		 
		while($row_img = mysqli_fetch_array($result_img))
		{ 
			if($row_img['image_name']!='')
			{
				$img_path = UPLOADS_URL .$row_img['image_name'];
				?>
				<a href="single-post-image-view.php?p_id=<?php echo $row_img['id']; ?>" >
					<img class="content_img_left" src="<?php echo $img_path?>" />
				</a>
				<?php
			} 
		}
	}

	function show_right_col_images_category($mysqli,$cat,$start_right){

		$query_select_img = "SELECT id, image_name FROM post WHERE post_category= '$cat' ORDER BY id DESC LIMIT ". $start_right. ",7 "; 
		$result_img = mysqli_query($mysqli, $query_select_img);	
		
		while($row_img = mysqli_fetch_array($result_img))
		{ 
			if($row_img['image_name']!='')
			{
				$img_path = MAIN_URL . "tagged/".$row_img['image_name'];
				?>
				<a href="single-post-image-view.php?p_id=<?php echo $row_img['id']; ?>" >
					<img class="content_img_left" src="<?php echo $img_path?>" />
				</a>
				<?php
			} 
		}
	}

	function show_single_image($mysqli,$post_id )
	{
		$query_select_posts = "SELECT id, image_name FROM posts WHERE id = $post_id"; 
		$result_posts = mysqli_query($mysqli, $query_select_posts);	
		$row_post = mysqli_fetch_array($result_posts);
		
		$img_path = UPLOADS_URL . $row_post['image_name']; 
		?>
			<img class="img_view_full" src="<?php echo $img_path; ?>" />
		<?php
	}

	function get_numb_views($mysqli,$post_id){

		$query_select_post_views= "SELECT views FROM posts WHERE id= $post_id" ;
		$result_fetch = mysqli_query($mysqli,$query_select_post_views);
		$result_select_postviews = mysqli_fetch_array($result_fetch);
		
		return $result_select_postviews['views']; 
	}

	function increment_numb_views($mysqli,$views_icr,$post_id){

		$query_update=("UPDATE posts SET views=$views_icr WHERE id='$post_id'");
		$result_update_postcounter = mysqli_query($mysqli,$query_update) ; 
	}

	function get_cat($mysqli,$post_id) {

		$query_select_post_cat= "SELECT category_id FROM posts WHERE id= $post_id" ;
		$result_fetch = mysqli_query($mysqli,$query_select_post_cat);
		$result_select_postcat = mysqli_fetch_array($result_fetch);
		
		return $result_select_postcat['category_id']; 
	}