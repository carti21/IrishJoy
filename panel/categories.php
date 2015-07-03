<?php
    require_once('includes/functions.php');

    sec_session_start();
    if (login_check($mysqli) == false) {
         header( 'Location: ' . MAIN_URL );
    }
?>

<html>
    <head>
        <title>Categories</title>
        <?php header_requires(); ?>
    </head>
    <body>
        <div class="head">
            <div class="right_head_bar"></div>
        </div>
        <div class="container">
            <div class="content">
                    <?php show_categories($mysqli); ?>
            </div>
            <div class="sidebar_right">
                <div class="menu_bar">
                	<?php show_panel(); ?>
                </div>
            </div>
        </div>
    </body>
</html>