<?php
    require_once('functions-public.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sq">
<html>
<head>
    <title>IrishJoy.com - Inspiration Is Everywhere.</title>
    <?php show_meta_tags(); ?>
    <link rel="stylesheet" type="text/css" href="css/public-style.css"/>
    <link rel="icon" href="<?php echo MAIN_URL; ?>images/favicon.png" type="image/x-icon">
</head>
<body>
<div class="head">
    <div class="head-image">
        <a class="header-link" href="<?php echo MAIN_URL; ?>">
            <img src="<?php echo MAIN_URL; ?>images/head_logo.jpg" alt="IrishJoy">
        </a>
    </div>
</div>
<div class="container">
    <div class="sidebar_right">
        <div class="ad_box">
            <a href="#">
                <img src="images/ads.png" alt="Advertising">
            </a>
        </div>
        <div class="ad_bottom">
            <div style="margin-top:15px;">
                <a href="http://www.intolaravel.com/">Our Partners</a>
            </div>
        </div>
        <div class="before_menu">
            <a href="https://github.com/ArditMustafaraj/IrishJoy" target="_blank">
                <img class="github_link" src="images/GitHub_Logo.png" alt="GitHub">
            </a>
        </div>
        <div class="menu_bar">
            <?php show_main_menu($mysql_conn); ?>
        </div>
    </div>
    <div class="content">

        <?php show_images($mysql_conn); ?>

    </div>
</div>
<div class="footer">
    <?php pagination(); ?>

    <div class="copyright">
        <a href="""http://www.intolaravel.com/" target="_blank">Powered by: Intolaravel</a>
    </div>
</div>
<?php show_footer_requires(); ?>

		