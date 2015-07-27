<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
    <head>
        <title>Post Edit</title>
        <?php header_requires(); ?>
    </head>
    <body>
        <div class="head"></div>
            <div class="container">
                <div class="content">
                    <?php
                        $id = $_GET[ 'p_id' ];
                        view_single_post_menu($mysqli, $id);
                    ?>
                    <p><b>Make the changes you want at this post:</br></b></p>
                    <form method="post" action="" enctype="multipart/form-data">
                        <label>Title:</label>
                        <input type="text" name="title_edit" value="<?php echo get_post_title($mysqli, $id); ?>"/>
                        </br></br>
                        <label> Category: </label>
                        <hr>
                        </br>
                        <div class="pull-right">
                            <button class="content_button" type="submit" name="post_edit">Edit</button>
                        </div>
                        <a href="single-post-view.php?p_id=<?php echo "$id"; ?>">
                            <img class="left-arrow" src="images/left_arrow.png">Cancel editing
                        </a>
                        </br> </br>
                    </form>
                    <?php
                        if (isset($_POST[ 'title_edit' ]) && isset($_POST[ 'category' ])) {
                            $title    = $_POST[ 'title_edit' ];
                            $category = $_POST[ 'category' ];
                            if (edit_post($mysqli, $id, $title, $category)) {
                                echo "sukses";
                            }
                        }
                    ?>
                </div>
                <div class="sidebar_right">
                    <div class="menu_bar">
                        <?php show_panel(); ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>