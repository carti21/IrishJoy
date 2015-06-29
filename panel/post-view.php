<?php

    include 'includes/functions.php';

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }

?>
<?php
    if(isset($_GET['del'])){
        if ($_GET[ 'del' ] == 1) {
            if ($_GET[ 'p_id' ] > 0) {
                $post_id = $_GET[ 'p_id' ];

                $post_category = get_post_category($mysqli, $post_id);
                $post_counter  = getNumOfPostsCategory($mysqli, $post_category);
                $post_counter--;

                $post_author    = get_post_author($mysqli, $post_id);
                $post_mem_count = getNumOfPosts($mysqli, $post_author);
                $post_mem_count--;


                delete_post($mysqli, $post_id, $post_category, $post_counter, $post_author, $post_mem_count);

                header('Location: ./posts-database.php');

            }
        }
    }
?>
<html>
    <head>
    <title>Img - <?php $id = $_GET[ 'p_id' ]; echo get_post_title($mysqli, $id); ?></title>
    <?php header_requires(); ?>
    </head>
    <body>
        <div class="head">     
        </div>
        <div class="container">
            <div class="content">
                <?php
                    if(isset( $_GET['p_id'])){
                        $id = $_GET[ 'p_id' ];
                    }

                    view_post_menu($mysqli, $id);
                    view_post($mysqli, $id);

                    if(isset( $_GET['edit'])){
                        if ($_GET[ 'edit' ] == 'success') {
                            echo '<div class="view-image">';
                            echo "&#10004; The post was successfully edited";
                            echo "</div>";
                        }
                    }    
                ?>
            </div>
            <div class="sidebar_right">
                <div class="menu_bar">
                    <?php show_panel() ?>
                </div>
            </div>
        </div>
    </body>
</html>