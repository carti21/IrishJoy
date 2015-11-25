<?php
require_once('functions-admin.php');

sec_session_start();
if (login_check($mysql_conn) == false) {
    header('Location: ' . MAIN_URL);
}
?>

    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="admin/css/admin-style.css"/>
        <link rel="stylesheet" type="text/css" href="admin/css/admin-style.css"/>
        <link rel="stylesheet" type="text/css" href="admin/css/admin-style.css"/>
        <link rel="stylesheet" type="text/css" href="admin/css/admin-style.css"/>
        <link rel="stylesheet" type="text/css" href="admin/css/admin-style.css"/>
        <title>Database</title>
        <?php header_requires(); ?>
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
        <script type="text/javascript">
            $(function () {
                $("table")
                    .tablesorter({widthFixed: true, widgets: ['zebra']})
                    .tablesorterPager({container: $("#pager")});
            });
        </script>
    </head>
<body>
<div class="posts_database_head">
    <div class="posts_database_left_box">
        <a style="color:#fff; text-decoration:none;" href="<?= ADMIN_URL ?>index.php">
            <img style=" width:15px; height:auto; margin-bottom:-3px; margin-right:3px;"
                 src="images/white_left_arrow.png">Back
        </a>
    </div>
    <div class="posts_database_right_box">

        <?php
        date_default_timezone_set('Europe/Berlin');
        echo date('l,  d.m.Y - H:i ');
        ?>
    </div>
</div>
<div class="containerDatabase">
    <div id="posts_database_content">
        <?php show_posts_database($mysql_conn) ?>

        <div id="pager" class="pager">
            <form>
                <img src="images/first.png" title="Newer Posts" class="arrow"/>
                <img src="images/previous.png" class="arrow"/>
                <input type="text" class="pageDisplay" title="page_number"/>
                <img src="images/next.png" class="arrow"/>
                <img src="images/last.png" title="Older Posts" class="arrow"/>

                <div class="pull-right">
                    <select class="pageSize" title="pageSize">
                        <option selected="selected" value="30" style="display:none;">Rows</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>
<?php footer_requires($mysql_conn); ?>