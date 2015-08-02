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
                        <textarea name="description" rows="6" cols="50"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label-post">Image Category:</label>
                        <select name="category_id">
                            <option>Select Category</option>
                            <?php 
                                $categories_array = get_categories_array($mysqli);
                                foreach($categories_array as $id=>$category){
                                    echo "<option value='$id'>$category</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-control">
                        <label>Choose the image from your computer</label>
                        <input type="file" name="skedar" size="40">
                    </div>
                        <hr>
                    <div class="form-control">
                        <input type="radio" name="status" value="1" checked>Public<br>
                        <input type="radio" name="status" value="0">Not Public
                    </div>
                    <button class="content_button">Publish</button>
                    <pre>
                     <?php
                                //get_categories_array($mysqli);
                            ?>
                </form>
                <?php

                    if (isset($_POST[ 'description' ])) {
                        $user_id = get_user_id();
                        $img_name = upload_image($_FILES[ 'skedar' ][ 'name' ],
                            $_FILES[ 'skedar' ][ 'size' ],
                            $_FILES[ 'skedar' ][ 'tmp_name' ]
                        );

                        new_post($mysqli,
                            $user_id,
                            $_POST[ 'description' ],
                            $_POST[ 'category_id' ],
                            $_POST[ 'status' ],
                            $img_name
                        );
                    }
                ?>
            </div>
            <div class="sidebar_right">
                <div class="menu_bar">
                    <?php show_panel_menu(); ?>
                </div>
            </div>
        </div>
    </body>
</html>