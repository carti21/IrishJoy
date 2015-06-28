<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == true) {

    }
    else {
        header('Location: ./');
    }

?>

<html>
    <head>
        <title>Add a new post</title>
        <?php header_requires(); ?>
        <script>
            $(document).ready(function () {
                $("#visible").click(function () {
                    $("#visibility").val("1");
                });
            });
            $(document).ready(function () {
                $("#notvisible").click(function () {
                    $("#visibility").val("0");

                });
            });
        </script>
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
                        <select name="category">
                            <option selected="true" style="display:none;">Select Category</option>
                            <?php
                                $query_select_categ = "SELECT id, category_name FROM category";
                                $result_categ = mysqli_query($mysqli, $query_select_categ);
                                while ($row_cat = mysqli_fetch_array($result_categ)) {
                                    echo "<option value=\"".$row_cat[ 'category_name' ]."\">"
                                        .$row_cat[ 'category_name' ]."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-control">
                        <label>Choose the image from your computer</label>
                        <input type="file" name="skedar" size="40">
                    </div>
                    <div class="form-control">
                        Make the post:
                        <h id="visible" style="color:green; cursor: pointer ;">Visible(1)</h>
                        &nbsp;&nbsp;&nbsp;
                        <h id="notvisible" style="color:red; cursor: pointer ;">Not Visible(0)</h>
                        <input type="text" name="visible" class="visibility" value="1">
                    </div>
                        <hr>
                    <div class="form-control">
                        <div class="pull-right">
                            <button id="content" type="submit">Publish</button>
                        </div>
                        <div class="pull-left">
                            <a href="posts.php" onclick="return confirm('Are you sure you want to cancel?')">Cancel</a>
                        </div>
                    </div>
                </form>
                <?php
                    if (isset($_POST[ 'post_title' ])) {
                        $member_name = show_member_whois($mysqli);

                        $member_post_number = getNumOfPosts($mysqli, $member_name);
                        $member_post_number++;

                        $cat           = $_POST[ 'category' ];
                        $category_numb = getNumOfCategoriesSP($mysqli, $cat);
                        $category_numb++;

                        $img_name = upload_image($_FILES[ 'skedar' ][ 'name' ],
                            $_FILES[ 'skedar' ][ 'size' ],
                            $_FILES[ 'skedar' ][ 'tmp_name' ]
                        );

                        new_post($mysqli,
                            $member_name,
                            $_POST[ 'post_title' ],
                            $_POST[ 'category' ],
                            $_POST[ 'visible' ],
                            $img_name,
                            $member_post_number,
                            $category_numb
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