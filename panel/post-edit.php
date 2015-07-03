<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header('Location: ' . MAIN_URL);
    }
?>

<html>
    <head>
        <title>Post Edit</title>
        <?php header_requires(); ?>
        <script>
            $("#custom_menu_button").ready(function () {
                $("#custom_menu1").hide();
                $("#custom_menu2").hide();
                $("#custom_menu3").hide();
                $("#custom_menu_button").click(function () {
                    $("#custom_menu1").fadeToggle(400);
                    $("#custom_menu2").fadeToggle(600);
                    $("#custom_menu3").fadeToggle(800);
                });
            });
        </script>
    </head>
    <body>
        <div id="head"><?php head_custom_menu(); ?></div>
            <div id="container">
                <div id="content">
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
        <div id="sidebar_right">
            <div id="menu_bar">
                <?php show_panel() ?>
            </div>
        </div>
    </div>
    </body>
</html>