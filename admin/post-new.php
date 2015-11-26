<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
        header('Location: ' . MAIN_URL);
    }
?>

    <html>
    <head>
        <title>New Post</title>
        <?php header_requires(); ?>
    </head>
<body>
<div class="head"></div>
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
                        $categories_array = get_categories_array($mysql_conn);
                        foreach ($categories_array as $id => $category) {
                            echo "<option value='$id'>$category</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-control">
                <label>Choose the image from your computer</label>
                <input type="file" name="input_image" size="40">
            </div>
            <hr>
            <div class="form-control">
                <input type="radio" name="status" value="1" checked>Public<br>
                <input type="radio" name="status" value="0">Not Public
            </div>
            <input name="content_button" type="submit" value="Publish">
        </form>
        <?php

            if (isset($_POST['content_button'])) {

                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_SPECIAL_CHARS);
                $status      = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
                $img_name    = $_FILES['input_image']['name'];
                $user_id     = filter_var($_SESSION['user_id']);

                new_post($mysql_conn, $user_id, $description, $category_id, $status, $img_name);
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