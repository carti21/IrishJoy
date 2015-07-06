<?php

    $root = realpath(__DIR__ . '/..');
    include "$root/config.php";

    function header_requires(){
        ?>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo PANEL_URL; ?>css/css_panel.css"/>
        <link rel="icon" href="<?php echo PANEL_URL; ?>images/favicon.png" type="image/x-icon">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <?php
    }

    function sec_session_start(){
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure       = false; // Set to true if using https.
        $httponly     = true; // This stops javascript being able to access the session id.
        $lifecookie   = 60*10; // lifetime of the cookie

        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($lifecookie, $cookieParams[ "path" ], $cookieParams[ "domain" ], $secure, $httponly);
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.  
    }

    function checkbrute($user_id, $mysqli) {
        // Get timestamp of current time
        $now = time();
        $valid_attempts = $now-(2*60*60);

        if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 5) {
                //means that it has previous error login attempts in the past X minutes
                return true;
            }
            else {
                //clear to go
                return false;
            }
        }
    }

    function login($email, $password, $user_ip, $mysqli) {

        // Using prepared Statements means that SQL injection is not possible.
        if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM users WHERE email = ? LIMIT 1")) {
            $stmt->bind_param('s', $email); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $db_password, $salt); // get variables from result.
            $stmt->fetch();
            $password = hash('sha512', $password.$salt); // hash the password with the unique salt.

            if ($stmt->num_rows == 1) { // If the user exists
                // We check if the account is locked from too many login attempts
                if (checkbrute($user_id, $mysqli) == true) {
                    // the account was suspended due to many login attempts
                    return false;
                }
                else {
                if ($db_password == $password) { // Check if the password in the database matches the password the user submitted.
                    // Password is correct!
                    $user_browser = $_SERVER[ 'HTTP_USER_AGENT' ]; // Get the user-agent string of the user.
                    $user_id                    = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                    $_SESSION[ 'user_id' ]      = $user_id;
                    $username                   = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                    $_SESSION[ 'username' ]     = $username;
                    $_SESSION[ 'login_string' ] = hash('sha512', $password.$user_browser);

                    // Login successful.
                    return true;
                }
                    else {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts (user_id, time , ip) VALUES ('$user_id', '$now','$user_ip')");

                        return false;
                    }
                    }
                }
                else {
                    // No user exists.
                    return false;
                }
            }
        }
    

    function show_user_whois(){
        return $_SESSION[ 'user_id' ];
    }

  function login_check($mysqli) {
        if(isset($_SESSION[ 'user_id' ])){
            $id_user     = $_SESSION[ 'user_id' ];
            $check_query = "SELECT id FROM users WHERE id='$id_user' LIMIT 1";
            $adm         = mysqli_fetch_array(mysqli_query($mysqli, $check_query));

            // Check if all session variables are set
            if (isset($_SESSION[ 'user_id' ], $_SESSION[ 'username' ], $_SESSION[ 'login_string' ])) {
                $user_id      = $_SESSION[ 'user_id' ];
                $login_string = $_SESSION[ 'login_string' ];
                $username     = $_SESSION[ 'username' ];
                $user_browser = $_SERVER[ 'HTTP_USER_AGENT' ]; // Get the user-agent string of the user.
                if ($stmt = $mysqli->prepare("SELECT password FROM users WHERE id = ? LIMIT 1")) {
                    $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
                    $stmt->execute(); // Execute the prepared query.
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) { // If the user exists
                        $stmt->bind_result($password); // get variables from result.
                        $stmt->fetch();
                        $login_check = hash('sha512', $password.$user_browser);
                        if ($login_check == $login_string) {
                            // Logged In!!!!
                            return true;
                        }
                        else {
                            // Not logged in
                            return false;
                        }
                    }
                    else {
                        // Not logged in
                        return false;
                    }
                }
                else {
                    // Not logged in
                    return false;
                }
            }
            else {
                // Not logged in
                return false;
            }
        }   
    }

    function delete_category($mysqli, $id) {

        $query_del = "DELETE FROM category WHERE id=$id";
        $result_del = mysqli_query($mysqli, $query_del)
        or
        die('Problem: '.mysqli_error($mysqli));
    }

    function edit_category($mysqli, $category_name, $id) {

        if ($category_name != '') {
            $query_update = " UPDATE  category  SET category_name='$category_name' WHERE id=$id ";
            $result_del = mysqli_query($mysqli, $query_update)
            or
            die('Problem: '.mysqli_error($mysqli));
        }
    }

    function new_category($mysqli, $cat_name) {

        if ($cat_name != '') {
            $query_insert   = "INSERT INTO categories (category_name) VALUES ('$cat_name')";

            if (!mysqli_query($mysqli,$query_insert)){
                  die('Problem: ' . mysqli_error($mysqli));
            } 
  
            header("Location: categories.php");
        }
    }

    function show_categories($mysqli) {
        $query = "SELECT categories.id, categories.category_name, posts.post_views FROM categories 
                    JOIN posts ON posts.category_id = categories.id ORDER BY categories.id ";
        $result = mysqli_query($mysqli, $query) or die(mysqli_error());
        ?>
        <table id="table_style" > 
            <thead> 
                <tr> 
                    <th scope="col"><b> Category </b></th> 
                    <th scope="col" align="center"><b>Posts </b></th> 
                    <th scope="col" align="right"><b> Edit </b></th> 
                    <th scope="col" align="center"><b> Delete </b></th> 
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td title="<?php $row[ 'category_name' ]?>"&#39;s&nbsp;ID&nbsp;&nbsp;"<?php $row[ 'id' ]; ?>"><?php echo $row[ 'category_name' ]; ?></td>
                        <td align="center" ><?php echo $row['post_views'] ?></td>

                        <td align="right"><a href="categories.php?id=<?php echo $row[ 'id' ]; ?>&edit=1">Edit</a></td>
                        <td align="center"><a onclick="return confirm('Press OK to delete the Category. ')" href="categories.php?id="<?php echo $row[ 'id' ]; ?>"&del=1">Delete</a></td>
                    </tr>
                <?php   
                } 
                ?>
            </tbody>
        </table>
        <?php
    }

    function show_category_menu(){
        ?>
        <div id="user_menu">
            <a  title="See the list of all categories" href="<?php echo PANEL_URL; ?>categories.php"> Categories </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>categories-new.php" title="Add a new category">Add a category </a>
        </div>
        <?php
    }


    function getNumOfCategoriesSP($mysqli, $cat_name) {
        $query_select              = "SELECT post_number FROM category WHERE category_name='$cat_name'";
        $result_fetch              = mysqli_query($mysqli, $query_select);
        $result_select_postcounter = mysqli_fetch_array($result_fetch);

        return $result_select_postcounter[ 'post_number' ];
    }

    function show_panel(){
        ?>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>panel.php"> Panel </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>post-new.php"> New Post </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>categories.php"> Categories </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>users.php"> Users </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>posts-database.php" target="_blank"> Post Database </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>panel.php">Test gallery</a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>search.php">Search</a> </div>
        <div class="menu_items"> <a href="<?php echo GOOGLE_ANALYTICS_URL; ?>" target="_blank" > Google Analytics </a> </div>
        <div class="menu_items"> <a href="<?php echo PHPMYADMIN_URL; ?>" target="_blank">'PHP MY Admin' </a> </div>
        <div class="menu_items"> <a href="<?php echo EMAIL_URL; ?>" target="_blank">Check Mail</a> </div>

        </br>

        <div class="menu_items"><a  href="<?php echo MAIN_URL; ?>" target="_blank"> Website - Public </a> </div>
        <?php
    }

    function head_custom_menu(){
        ?>
        <div style="float:right; margin-right: 30px;">
            <button id="custom_menu_button" style="width:80px;" class="custom_menu" >
                <img style="margin-right:3px" src="images/gear.png" border=0 width="15px" height="15px"> Panel 
            </button>

            <a href="<?php echo PANEL_URL ?>users.php" style="text-decoration:none;">
                <div id="custom_menu1" style="border-radius:3px 3px 0px 0px;"> 
                    <img style="margin-right:3px;" src="images/users_custom.png" border=0 width="15px" height="15px">users 
                </div>
            </a>

            <a href="<?php echo PANEL_URL ?>logout.php" style="text-decoration:none;"> 
                <div id="custom_menu3" style="border-radius:0px 0px 3px 3px;">
                    <img style="margin-right:3px" src="images/logout.png" border=0 width="15px" height="15px"> Logout
                </div>
            </a>
        </div>
     <?php
    }

    function show_login_attempts($mysqli) {

    $query_select_mem = "SELECT user_id, act_time,ip FROM login_attempts ORDER BY act_time DESC ";
    $result_mem       = mysqli_query($mysqli, $query_select_mem);
    ?>
    <table id="table_style"> 
        <thead> 
            <tr> 
                <th scope="col" align="center"><b> user ID </b></th> 
                <th scope="col" align="center"><b>Time</b></th> 
                <th scope="col" align="center"><b>IP</b></th> 
            </tr>
        </thead>
        <tbody>
            <?php
            while ($data = mysqli_fetch_array($result_mem)) {
                ?>
                <tr>
                    <td align="center" ><?php echo $data[ 'user_id' ]; ?></td>
                    <td align="center" title="<?php echo(date("l, d F  H:i", strtotime($data[ 'act_time' ])))?>"></td>
                    <td align="center" ><?php echo $data[ 'ip' ]; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    }

    function show_user_login_traces($mysqli) {
        $query_select_trace = "SELECT id, user_id, time, ip FROM login_filter ORDER BY id DESC";
        $result_trace_login = mysqli_query($mysqli, $query_select_trace);
        ?>

        <table cellspacing="1" class="tablesorter" style="cursor: default;"
            <thead>
                <tr>
                    <th>&nbsp;U / Email</th>
                    <th style="text-align:center; ">Time</th
                    <th style="text-align:center; ">IP</th>
                </tr>
            </thead>
        <tbody>
        <?php
            while ($data = mysqli_fetch_array($result_trace_login)) {
                ?>
                <tr>
                    <td><?php echo"&nbsp;".substr($data[ 'user_id' ], 0, 30) ?> </td>
                    <td title="<?php echo date("l, d F  H:i", strtotime($data[ 'time' ])); ?>" style="text-align:center; "><?php echo date("d.m.Y - H:i", strtotime($data[ 'time' ])); ?></td
                    <td style="text-align:center; "><?php echo $data[ 'ip' ]; ?></td>
                </tr>
                <?php
            } ?>
        </tbody>
        </table>
        <?php
    }

    function add_user($mysqli, $username, $password, $email) {
        if ($username != '' and $password != '' and $email != '') {
            //$salt = substr( md5(rand()), 0, 32);
            $salt = 'b6996ff1f4b068b75f1b10e76dee99acf202c05a03fe3dd9745a92120d2ddcc2412e69078461bdcd4b04038697e76b1680647ca3837810c9a8feaaec691149a5';
 			//$password = substr( md5(rand()), 0, 7);
 			$password = hash('sha512', $password.$salt);
            if ($insert_stmt = $mysqli->prepare
                ("INSERT INTO users (username, email, password, salt) VALUES (?, ?, ?, ?)")
            ) {
                $insert_stmt->bind_param('ssss', $username, $email, $password, $salt);
                // Execute the prepared query.
                $insert_stmt->execute();
            }
        }
    }

    function delete_user($mysqli, $id) {
        $query_del = "DELETE FROM users WHERE id=$id";
        $result_del = mysqli_query($mysqli, $query_del)
        or
        die('Problem: '.mysqli_error($mysqli));
    }

    function show_user_menu(){
        ?>
        <div id="user_menu">
            <a  title="See all users list" href="<?php echo PANEL_URL; ?>users.php">users</a>
            &nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>users-login-attempts.php" title="See all error logins from users">users Login Attempts</a>
            &nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>users-new.php" title="Add a new user">Add a user</a>
            &nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>users-login-traces.php" title="Show Login Traces">Login Traces</a>
        </div>
        <?php
    }

    function view_user_menu(){
        ?>
        <div id="user_menu">
            <a  title="See the list of all categories" href="<?php echo PANEL_URL; ?>categories.php">Edit Profile </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>categories-new.php" title="Add a new category">Add a category </a>
        </div>
        <?php
    }

    function view_user($mysqli, $user_id) {
        $query_select_user = "SELECT id, username, email FROM users WHERE id = $user_id";
        $result_user       = mysqli_query($mysqli, $query_select_user);
        $row_user          = mysqli_fetch_array($result_user);


        echo "Name: ".$row_user[ 'username' ]." ";
        echo "</br>";
        echo "Email: ".$row_user[ 'email' ]." ";
        echo "</br>";
    }

    function show_users($mysqli) {

       /* $query_select = ("SELECT post_counter FROM users");
        $result_fetch = mysqli_query($mysqli, $query_select);*/

        $query_select_mem = "SELECT id, username, email FROM users ORDER BY id";
        $result_mem       = mysqli_query($mysqli, $query_select_mem);

        ?>
        <table id="table_style"> 
            <thead> 
            <tr> 
                <th scope="col"><b> Username </b></th> 
                <th scope="col"><b> Email </b></th> 
                <th scope="col" align="right"><b>Posts</b></th> 
                <th scope="col" align="center"><b> View </b></th> 
            </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_array($result_mem)) {
                 ?>
                
                <tr>
                    <td title="."user&nbsp;ID:&nbsp;".$data[ 'id' ]."><?php echo $data[ 'username' ]; ?></td>
                    <td><?php echo $data[ 'email' ]; ?></td>
                    <td align="right"><?php echo "not set" ?></td>
                    <td align="center">
                        <a href="user-view.php?m_id="<?php echo $data[ 'id' ]; ?> >
                            <img src="images/user.png" border=0 width="15" height="15">
                        </a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }


    function show_statistics($mysqli) {
        $query_categories  = "SELECT category_name FROM categories";
        $categories_result = mysqli_query($mysqli, $query_categories);
        $category_amount   = mysqli_num_rows($categories_result);


        $query_posts  = "SELECT id FROM posts";
        $posts_result = mysqli_query($mysqli, $query_posts);
        $post_amount  = mysqli_num_rows($posts_result);

        $query_users  = "SELECT id FROM users";
        $users_result = mysqli_query($mysqli, $query_users);
        $users_amount = mysqli_num_rows($users_result);
        ?>
        <table id="table_style"> 
            <thead> 
                <tr> 
                    <th scope=\"col\"><b> Items </b></td>
                    <th scope=\"col\"><b> Amount </b></td>
                </tr> 
            </thead> 
            <tbody>
            <tr> 
                <td><b> Posts </b></td> 
                <td><?php echo $post_amount;?></td> 
            </tr> 
            <tr> 
                <td><b> Categories </b></td> 
                <td><?php echo $category_amount;?></td> 
            </tr> 
            <tr> 
                <td><b> users </b></td> 
                <td><?php echo  $users_amount; ?></td> 
            </tr> 
            </tbody>
        </table>
        <?php
    }

    function getNumOfPosts($mysqli, $user) {
        $query_select              = "SELECT post_counter FROM users WHERE username='$user'";
        $result_fetch              = mysqli_query($mysqli, $query_select);
        $result_select_postcounter = mysqli_fetch_array($result_fetch);

        return $result_select_postcounter[ 'post_counter' ];
    }

    function getNumOfPostsCategory($mysqli, $category) {
        $query_select              = "SELECT post_number FROM category WHERE category_name='$category'";
        $result_fetch              = mysqli_query($mysqli, $query_select);
        $result_select_postcounter = mysqli_fetch_array($result_fetch);

        return $result_select_postcounter[ 'post_number' ];
    }

    function get_post_title($mysqli, $post_id) {
        $query_title  = "SELECT id, post_title FROM post WHERE id = $post_id";
        $result_title = mysqli_query($mysqli, $query_title);
        $data_title   = mysqli_fetch_array($result_title);

        return $data_title[ 'post_title' ];
    }

    function get_post_author($mysqli, $post_id) {
        $query_author  = "SELECT id, post_author FROM post WHERE id = $post_id";
        $result_author = mysqli_query($mysqli, $query_author);
        $data_author   = mysqli_fetch_array($result_author);

        return $data_author[ 'post_author' ];
    }

    function get_post_category($mysqli, $post_id) {
        $query_cat  = "SELECT id, post_category FROM post WHERE id = $post_id";
        $result_cat = mysqli_query($mysqli, $query_cat);
        $data_cat   = mysqli_fetch_array($result_cat);

        return $data_cat[ 'post_category' ];
    }


    function delete_post($mysqli, $id, $category, $category_post_numb, $author, $mem_post_counter) {
        $query_del  = "DELETE FROM posts WHERE id=$id";

        if(mysqli_query($mysqli, $query_del)){
            header('Location: ./posts-database.php');
        } else { 
            die('Problem: '.mysqli_error($mysqli));
        }  
    }

    function edit_post($mysqli, $post_id, $title, $category) {
        //Nese nuk ka input tek titulli dhe kategoria, nuk shtohet
        if( ($title != " "))
        {
            $query_update_post  = "UPDATE post SET post_title='$title', post_category='$category' WHERE id=$post_id";
            $result_update_post = mysqli_query($mysqli, $query_update_post);
            header("Location: " . PANEL_URL ."post-view.php?p_id=".$post_id."&edit=success");
        }
    }

    function new_post($mysqli, $user, $title, $category, $visibility, $img_new_name) {

        if (($title != '') && ($category != '')) {
            $query_insert_post = "INSERT INTO posts (post_author, post_title, post_status, category_id, post_photo_name)
                                       VALUES ('$user', '$title' , '$visibility', '$category', '$img_new_name')";
            $result_add_post   = mysqli_query($mysqli, $query_insert_post);

            echo '<p>New post has been added. </p>';
        }
    }

    function upload_image($img_name, $img_size, $tmp) {
        // duhet futur kushti qe shef a esht apo jo img nisur nga prapashtesa

        if ($img_size < 1024*1024*2) // size < 2MB
        {
            // emrit i shtohet nje nr random qe mos ngaterrohet
            $img_new_name = rand(00, 9999).strtolower(str_replace(' ', '-', $img_name));

            if (move_uploaded_file($tmp, SERVER_URL.'uploads/'.$img_new_name)) {
                chmod(SERVER_URL.'uploads/'.$img_new_name, 0666);
                echo '<p>The image was updated successfully</p>';

                return $img_new_name;
            }
            else {
                echo '<p>There was a problem during upload. Please try again.</p>';

            }
        }
    }

    function view_post_menu($mysqli, $id) {
        $query_posts   = "SELECT id, post_status, post_date, post_views FROM posts WHERE id = $id";
        $result_posts  = mysqli_query($mysqli, $query_posts);
        $row_post_menu = mysqli_fetch_array($result_posts);
        ?>
        <div id="user_menu"  >
        <a title="Edit this post" href="post-edit.php?p_id=<?php echo $id; ?>">Edit</a>
            |
        <a onclick="return confirm('Press OK to delete this post. ')" href="?p_id=<?php echo $id; ?>&del=1" title="Delete this post">Delete</a>
            |
        <a title="Add a new post" href="post-new.php">New Post</a>
        
        <span title="<?php echo (date("l, d F, H:i", strtotime($row_post_menu[ 'post_date' ]))); ?>" style="margin-left:50px; color:#336699; cursor:default;">
            <?php echo (date("d.m.Y - H:i", strtotime($row_post_menu[ 'post_date' ]))); ?>
        </span>
        <?php 
        if ($row_post_menu[ 'post_status' ] == '1') {
            ?>
            <span style="float:right; margin-right:10px; cursor:default; color:#008000; font-weight:bold;">
            Published
            </span>
            <?php 
        }
        else {
            ?>
            <span style="float:right; margin-right:10px; color:#AF0000; font-weight:bold;">
            Not Published
            </p>
            <?php 
        } ?>
        </div>
        <?php 
    }

    function view_post($mysqli, $post_id) {
        $query_select_posts = "SELECT posts.id, posts.post_author, posts.post_title, posts.category_id, posts.post_views, posts.post_photo_name, categories.category_name FROM posts 
                               JOIN categories ON categories.id = posts.category_id WHERE  posts.id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);

        if ( !empty($row_post[ 'post_title' ]) ) {
            ?>
            <div class="pull-left">
                <div class="items">
                    <span class="post-details">
                    Title: </span><?php echo $row_post[ 'post_title' ]; ?>
                </div>
                <div class="items">
                    <span class="post-details">
                    Img Name: </span><?php echo $row_post[ 'post_photo_name' ]; ?>
                </div>
                <div class="items">
                    <span class="post-details">
                    Category: </span><?php echo  $row_post[ 'category_name' ]; ?>
                </div>
                <div class="items">
                    <span class="post-details">
                    Author: </span><?php echo $row_post[ 'post_author' ]; ?>
                </div>
                <div class="items">
                <span class="post-details">
                Views: </span><b><?php echo $row_post[ 'post_views' ]; ?> 
                </div>
                
                <a href="posts-database.php" class="post-details ">
                    <img style="width:15px; margin-bottom:-3px; height:auto;"src="images/left_arrow.png">Go to database
                </a>
                <?php
                $img_path = UPLOADS_URL . $row_post[ 'post_photo_name' ];
                if ($row_post[ 'post_photo_name' ] == '') {
                    ?>
            </div>
               <p style="width:200px; float:right; color:red; font-weight:bold;">
               This image cannot be found!
               </p>
               <?php
            }
            else {
                ?>
               </div>
               <a href="view-image.php?p_id=<?php echo $row_post[ 'id' ]; ?>" ><img class="post_view_img" title="View full image" src="<?php echo $img_path; ?>" /></a>
               <?php
            }
        }
        else {
            ?>
            <div>
                This post may not exist!
            </div>
            <?php
        }
    }

    function view_image_menu($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_title FROM post WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);
        ?>
        <div id="user_menu" style="width:491px;" >
            <span style="color:#336699; padding-left:10px"><?php echo $row_post[ 'post_title' ]; ?></span>
            <a href="post-view.php?p_id=<?php echo $post_id; ?>">
                <span style="float:right; margin-right:10px; color:#336699; font-weight:bold;">
                    Back
                </span>
                <img style="float:right; width:15px; margin-top:2px; margin-right:5px; height:auto;" src="images/left_arrow.png">
            </a>
        </div>
        <?php
    }

    function view_image($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_photo_name FROM post WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);

        $img_path = UPLOADS_URL . $row_post[ 'post_photo_name' ];
        //echo "<img class=\"img_view_full\" src= \"$img_path\" />";
        echo "<a href=\"post-view.php?p_id=".$row_post[ 'id' ]."\" ><img class=\"img_view_full\" title=\"Back to detailed view\" src= \"$img_path\" /></a>";
    }

    function show_posts_database($mysqli) {
        $query_select_posts = "SELECT posts.id, posts.post_author, posts.post_date, posts.post_title, posts.post_status, posts.category_id, posts.post_photo_name, posts.post_views, categories.category_name FROM posts 
                               JOIN categories ON categories.id = posts.category_id ORDER BY id DESC";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
    ?>

        <table cellspacing="1" class="tablesorter">
            <thead> 
                <tr> 
                    <th> Post title / Description </th> 
                    <th> Date </th>
                    <th> Author </th> 
                    <th> Category </th> 
                    <th> P/U &nbsp;&nbsp; </th>
                    <th> Image Name </th>
                    <th> Views </th>
                    <th> Press </th>
                </tr> 
            </thead> 
        <tbody> 
    <?php 
        while ($data = mysqli_fetch_array($result_posts)) {
    ?>
            <tr>
                <td style="cursor: default;" title="<?= $data[ 'post_title' ]; ?>"> <?= substr($data[ 'post_title' ], 0, 40); ?> </td>
                <td title="<?= (date("l, d F  H:i", strtotime($data[ 'post_date' ]))) ?>" style="text-align:center; cursor: default;"> <?= (date("d.m.Y - H:i", strtotime($data[ 'post_date' ]))) ?> </td>
                <td> <?= $data['post_author']; ?> </td>
                <td> <?= $data['category_name']; ?> </td>
                <td class="text-center" style="cursor: default;"> <?= $data['post_status'] ?> </td>
                <td style="cursor: default;" title="<?= $data[ 'post_photo_name'] ?>"> <?= substr($data[ 'post_photo_name' ], 0, 15) ?> </td>
                <td style="text-align:right;" ><?= $data[ 'post_views' ]; ?> </td>
                <td title="View&nbsp;&nbsp; <?=$data['id'] ?>" style="text-align:center; cursor:default"><a href="post-view.php?p_id=<?= $data['id']; ?>" /><img src="images/open.png" class="p_db_img_view"></td>
            </tr>
      <?php  } ?>
        </tbody> 
        </table> 
    <?php
    }


    function getRealIpAddr(){
        if (!empty($_SERVER[ 'HTTP_CLIENT_IP' ])) //check ip from share internet
        {
            $ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
        }
        else {
            if (!empty($_SERVER[ 'HTTP_X_FORWARDED_FOR' ])) //to check ip is pass from proxy
            {
                $ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
            }
            else {
                $ip = "".$_SERVER[ 'REMOTE_ADDR' ]." ";
            }
        }

        return $ip;
    }

?>