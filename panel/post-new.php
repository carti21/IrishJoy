<?php
    require_once('functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
    <head>
        <title>New Post</title>
        <?php header_requires(); ?>
    </head>
    <body>
        <div class="head">
            <div class="right_head_bar"></div>
        </div>
        <div class="container">
            <div class="content">
                <h2>Add a new post:</h2>
                <form method="post" action="" enctype="multipart/form-data">        
                    <div class="form-control">
                        <label class="label-post">Image Description or tags:</label>
                    </div>
                    <div class="form-control">
                        <textarea name="post_title" rows="6" cols="50"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label-post">Image Category:</label>
                        <select name="category_id">
                            <option selected="true">Select Category</option>
                            <?php
                                
                            ?>
                        </select>
                    </div>
                    <div class="form-control">
                        <label>Choose the image from your computer</label>
                        <input type="file" name="skedar" size="40">
                    </div>
                        <hr>
                    <div class="form-control">
                        <input type="radio" name="post_status" value="1" checked>Public<br>
                        <input type="radio" name="post_status" value="0">Not Public
                    </div>
                    <button class="content_button">Publish</button>
                </form>
                <?php

                    if (isset($_POST[ 'post_title' ])) {
                        $user_id = get_user_id();
                        $img_name = upload_image($_FILES[ 'skedar' ][ 'name' ],
                            $_FILES[ 'skedar' ][ 'size' ],
                            $_FILES[ 'skedar' ][ 'tmp_name' ]
                        );

                        new_post($mysqli,
                            $user_id,
                            $_POST[ 'post_title' ],
                            $_POST[ 'category_id' ],
                            $_POST[ 'post_status' ],
                            $img_name
                        );
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