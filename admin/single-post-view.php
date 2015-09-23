<?php

    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header('Location: ' . MAIN_URL);
    }

?>
<?php
    if(isset($_GET['del'])){
        if ($_GET[ 'del' ] == 1) {
            if ($_GET[ 'post-id' ] > 0) {
                $post_id = $_GET[ 'post-id' ];
                delete_post($mysql_conn, $post_id, $post_category, $post_counter, $user_id, $post_mem_count);
            }
        }
    }
?>
<html>
    <head>
    <title><?php $id = $_GET[ 'post-id' ]; echo get_post_title($mysql_conn, $id); ?></title>
    <?php header_requires(); ?>
    </head>
    <body>
        <div class="head"></div>
        <div class="container">
            <div class="content">
                <?php
                    if(isset( $_GET['post-id'])){
                        $id = $_GET[ 'post-id' ];
                    }

                    view_single_post_menu($mysql_conn, $id);
                    
                    view_single_post($mysql_conn, $id);

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
                    <?php show_admin_menu(); ?>
                </div>
            </div>
        </div>
    <?php footer_requires($mysql_conn); ?>