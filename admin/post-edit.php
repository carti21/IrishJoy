<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
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
            $id = filter_input(INPUT_GET, 'post-id', FILTER_SANITIZE_SPECIAL_CHARS);
            view_single_post_menu($mysql_conn, $id);
        ?>
        <p><b>Make the changes you want at this post:<br></b></p>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-control">
                <label class="label-post">Image Description or tags:</label>
            </div>
            <div class="form-control">
                <textarea name="description" rows="6"
                          cols="50"><?php echo get_post_description($mysql_conn, $id); ?></textarea>
            </div>
            <div class="form-control">
                <label class="label-post">Image Category:</label>
                <select name="category_id">
                    <option disabled selected>Select Category</option>
                    <?php
                        $categories_array = get_categories_array($mysql_conn);
                        $post_category_id = get_post_category($mysql_conn, $id);
                        foreach ($categories_array as $category_id => $category_name) {
                            ?>
                            <option
                                value="<?php echo $category_id; ?>" <?php if ($post_category_id == $category_id) echo 'selected'; ?> >
                                <?php echo $category_name; ?>
                            </option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-control">
                <?php $post_status = get_post_status($mysql_conn, $id); ?>
                <input type="radio" name="status" value="1" <?php if ($post_status == 1) echo 'checked'; ?>>Public<br>
                <input type="radio" name="status" value="0" <?php if ($post_status == 0) echo 'checked'; ?>>Not Public
            </div>

            <div class="pull-right">
                <button class="content_button" type="submit" name="post_edit">Edit</button>
            </div>
            <a href="single-post-view.php?post-id=<?php echo "$id"; ?>">
                <img class="left-arrow" src="images/left_arrow.png">Cancel editing
            </a>
            <br> <br>
        </form>
        <?php

            if (isset($_POST['description']) && isset($_POST['category_id'])) {

                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                $category    = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_SPECIAL_CHARS);
                $status      = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

                edit_post($mysql_conn, $id, $description, $category, $status);
            }

        ?>
    </div>
    <div class="sidebar_right">
        <div class="menu_bar">
            <?php show_admin_menu(); ?>
        </div>
    </div>
</div>
</body>
<?php footer_requires($mysql_conn); ?>