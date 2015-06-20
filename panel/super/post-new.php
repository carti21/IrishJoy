<?php
    include 'includes/db_connect.php';
    include 'includes/functions.php';
    error_reporting(); // jane gabime qe duhen pare ne fund !!!
    // Include database connection and functions here.
    sec_session_start();
    if (login_check($mysqli) == true) {

        // Add your protected page content here!

    }
    else {
        header('Location: ./');
    }

?>


<html>
<head>
    <title>Add a new post</title>
    <link rel="stylesheet" type="text/css" href="css/css_panel.css"/>
    <link rel="icon" href="http://irishjoy.flivetech.com/panel/super/images/favicon.png" type="image/x-icon">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
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

<div id="head">
    <div id="right_head_bar"></div>
</div>

<div id="container">
    <div id="content">
        <p><b>Add a new post now:</br></b></p>


        <form method="post" action="" enctype="multipart/form-data">
            <label>Image Description:</label>
            <input type="text" name="post_title" style="width:90%"/>

            </br></br>    </br></br>

            <label>Image Category:</label>
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

            </br></br></br>

            <label>Please selec the image from your computer</label>
            <input type="file" name="skedar" size="40">

            </br></br>
            Make the post:
            <h id="visible" style="color:green; cursor: pointer ;">Visible(1)</h>
            &nbsp;&nbsp;&nbsp;
            <h id="notvisible" style="color:red; cursor: pointer ;">Not Visible(0)</h>
            <input type="text" name="visible" id="visibility" value="1"
                   style="width: 80px; text-align: center; background: none; float:right;"/>
            </br> </br></br>

            <hr>
            </br>
            <div style="float:right;">
                <button class="content" type="submit">Publish</button>
            </div>

            <div style="float:left;">
                <a href="posts.php" onclick="return confirm('Are you sure you want to cancel?')">Cancel</a>
            </div>
            </br> </br>


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

    <div id="sidebar_right">
        <div id="menu_bar">
            <?php show_panel() ?>
        </div>
    </div>

</div>


</body>
</html>