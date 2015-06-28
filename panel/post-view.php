<?php

    include 'includes/functions.php';

    sec_session_start();
    if (login_check($mysqli) == true) {

        // Add your protected page content here!

    }
    else {
        header('Location: ./');
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Img - <?php $id = $_GET[ 'p_id' ];
            $title = get_post_title($mysqli, $id);
            echo "$title"; ?></title>
    <link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/css_panel.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        $("#custom_menu_button").ready(function () {
            $(".custom_menu1").hide();
            $(".custom_menu2").hide();
            $(".custom_menu3").hide();
            $(".custom_menu_button").click(function () {
                $(".custom_menu1").fadeToggle(400);
                $(".custom_menu2").fadeToggle(600);
                $(".custom_menu3").fadeToggle(800);
            });
        });
    </script>
</head>
    <body>
        <div class="head">     
            <?php head_custom_menu(); ?>
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