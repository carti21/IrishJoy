<?php
    require_once('functions-admin.php');

    sec_session_start();
    if (login_check($mysql_conn) == false) {
         header( 'Location: ' . MAIN_URL );
    }
?>

<html>
    <head>
        <title>Categories</title>
        <?php header_requires(); ?>
    </head>
    <body>
        <div class="head"></div>
        <div class="container">
            <div class="content">
                <?php 
                    show_category_menu();
                    view_all_categories($mysql_conn);
                ?>
            </div>
            <div class="sidebar_right">
                <div class="menu_bar">
                    <?php show_admin_menu(); ?>
                </div>
            </div>
        </div>
    <?php footer_requires($mysql_conn); ?>
