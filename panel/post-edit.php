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
                        view_post_menu($mysqli, $id);
                    ?>
                    <p><b>Make the changes you want at this post:</br></b></p>
                    <form method="post" action="" enctype="multipart/form-data">

                <label>Title:</label>
                <input type="text" name="title_edit" style="width:90%"
                       value="<?php $title = get_post_title($mysqli, $id);
                           echo "$title"; ?>"/>
                </br></br>
                <label> Category: </label>
                <select name="category">
                    <option selected="true" style="display:none;"
                            value="<?php $cat = get_post_category($mysqli, $id);
                                echo "$cat"; ?>">
                        <?php echo "$cat"; ?></option>

                    <?php
                        $query_select_categ = "SELECT id, category_name FROM category";
                        $result_categ = mysqli_query($mysqli, $query_select_categ);
                        while ($row_cat = mysqli_fetch_array($result_categ)) {
                            echo "<option value=\"".$row_cat[ 'category_name' ]."\">"
                                .$row_cat[ 'category_name' ]."</option>";
                        }

                    ?>
                </select>
                <hr>
                </br>
                <div style="float:right;">
                    <button class="content" type="submit" name="post_edit">Edit</button>
                </div>
                <a href="post-view.php?p_id=<?php echo "$id"; ?>">
                    <img style="width:15px; margin-bottom:-3px; height:auto;"
                         src="images/left_arrow.png">Cancel editing</img></a>
                </a>
                </br> </br>
            </form>
            <?php
                if (($_POST[ 'title_edit' ]) && ($_POST[ 'category' ])) {
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
                <?php show_panel() ?>
            </div>
        </div>
    </div>
    </body>
</html>