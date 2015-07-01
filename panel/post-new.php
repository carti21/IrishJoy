<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
    <head>
        <title>Add a new post</title>
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
                        <input type="text" name="post_title">
                    </div>
                    <div class="form-control">
                        <label class="label-post">Image Category:</label>
                        <select name="category_id">
                            <option selected="true" style="display:none;">Select Category</option>
                            <?php
                                $query_select_categ = "SELECT id, category_name FROM categories";
                                $result_categ = mysqli_query($mysqli, $query_select_categ);
                                while ($row_cat = mysqli_fetch_array($result_categ)) {
                                    echo "<option value=\"".$row_cat[ 'id' ]."\">"
                                        .$row_cat[ 'category_name' ]."</option>";
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
                        <input type="radio" name="post_status" value="1" checked>Public<br>
                        <input type="radio" name="post_status" value="0">Not Public
                    </div>
                    <input type="submit" value="Publish">
                </form>
                <?php

                    if (isset($_POST[ 'post_title' ])) {
                        $user_id = show_member_whois();
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