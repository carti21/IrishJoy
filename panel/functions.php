<?php

    $root = realpath(__DIR__ . '/..');
    include "$root/config.php";

    /**
     * Echos the Header elements and includes
     */
    function header_requires(){
        ?>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo PANEL_URL; ?>css/css_panel.css"/>
        <link rel="icon" href="<?php echo PANEL_URL; ?>images/favicon.png" type="image/x-icon">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <?php
    }

    /**
     * Starts the session
     * @return [type] [description]
     */
    function sec_session_start(){
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure       = false; // Set to true if using https.
        $httponly     = true; // This stops javascript being able to access the session id.
        $lifecookie   = COOKIE_LIFETIME; // lifetime of the cookie

        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($lifecookie, $cookieParams[ "path" ], $cookieParams[ "domain" ], $secure, $httponly);
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.  
    }

    /**
     * Checks if the user has many login attempts
     * and is not allowed to login.
     * @param  int $user_id 
     * @param  $mysqli  [description]
     * @return boolean  false if is clear and ready to go, true if
     * the user has too many login attempts
     */
    function checkbrute($user_id, $mysqli) {
        // Get timestamp of current time
        $now = time();
        $valid_attempts = $now - BLOCK_USER_DURATION;

        if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > ?")) {
            $stmt->bind_param('ii', $user_id, $valid_attempts);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > MAX_LOGIN_ATTEMPTS) {
                //means that it has previous error login attempts in the past X minutes
                return true;
            }
            else {
                //clear to go
                return false;
            } 
        } 
    }

    /**
     * Login Function
     * @param  $mysqli MySql Connection
     * @param  string $email Email of the user to be verified 
     * @param  string $password Password of the user to be verified
     * @return bool true if login is done successfully, false otherwise
     */
    function login($mysqli, $email, $password){
        // Using prepared Statements means that SQL injection is not possible.
        if ($stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE email = ? LIMIT 1")) {
            $stmt->bind_param('s', $email); // Bind "$email" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $db_password); // get variables from result.
            $stmt->fetch();


            if ($stmt->num_rows == 1) { // If the user exists
                // We check if the account is locked from too many login attempts
                if (checkbrute($user_id, $mysqli) == true) {
                    // The account was suspended due to many login attempts
                    return false;
                }
                else {
                    if (password_verify($password, $db_password)) { 
                        // Password is correct!
                        $_SESSION[ 'user_id' ]      = $user_id;
                        $_SESSION[ 'email' ]        = $username;
                        $_SESSION[ 'login_string' ] = password_hash($password, PASSWORD_DEFAULT);
                        $_SESSION[ 'logged_in' ]    = true;
                        // Login successfully.
                        return true;
                    }
                    else {
                        // Password is not correct. This record attempt is stored in the database
                        $time = time();
                        if($insert_stmt_insert = $mysqli->prepare("INSERT INTO login_attempts (user_id, time ) VALUES (?, ?)")){
                            $insert_stmt_insert->bind_param('ii', $user_id, $time);
                            $insert_stmt_insert->execute();
                        }
                        return false;
                    }
                }
            }
            else {
                // User doesn't exists
                return false;
            }
        }
    }

    /**
     * Returns the logged user id. Gets the id from the session
     * @return int user_id
     */
    function get_user_id(){
        return $_SESSION[ 'user_id' ];
    }

    /**
     * Simply checks if the user is logged in or not
     * @param  $mysqli MySql Connection
     * @return boolean true if the user is logged, false if not
     */
    function login_check($mysqli) {

        if(isset($_SESSION[ 'user_id' ]) && isset($_SESSION[ 'logged_in' ]) && $_SESSION[ 'logged_in' ] == true ){

            return true;
        }
        return false;
    } 

    function delete_category($mysqli, $id) {

        $query_del = "DELETE FROM category WHERE id=$id";
        $result_del = mysqli_query($mysqli, $query_del)
        or
        die('Problem: '.mysqli_error($mysqli));
    }

    /**
    * Fucntion to Edit a specific Category
    * @param  $mysqli MySql Connection
    * @param  string $new_category_name the new name of the category to be stored
    * @param  [type] $id ID of the current category that is going to change
    * @return Returns to categories.php
    */
    function edit_category($mysqli, $new_category_name, $id) {

        if ($category_name != '') {
            $query_update = " UPDATE  categories  SET category_name='$new_category_name' WHERE id=$id ";
            $result_del = mysqli_query($mysqli, $query_update);
            header('Location: ./categories.php');
        }
    }

    /**
     * Function to create a category
     * @param  $mysqli MySql Connection
     * @param  string $category_name Name of the Category
     * @return Returns to categories.php
     */
    function add_category($mysqli, $category_name) {

        if ($cat_name != '') {
            $query_insert   = "INSERT INTO categories (category_name) VALUES ('$category_name')";

            if (!mysqli_query($mysqli,$query_insert)){
                  die('Problem: ' . mysqli_error($mysqli));
            } 
  
            header("Location: categories.php");
        }
    }

    /**
     * Gets the number of posts of a specific category
     * @param  $mysqli MySql Connection
     * @param  int $category_id ID of the current Category
     * @return int Number of posts by the Category
     */
    function get_number_of_posts_category($mysqli, $category_id){
        $query_select_category = "SELECT COUNT(*) AS id FROM posts WHERE category_id = $category_id";
        $result_category       = mysqli_query($mysqli, $query_select_category);
        $row_category          = mysqli_fetch_array($result_category);

        return ($row_category['id']);
    }

    /**
     * Function to display all categories and their number of posts
     * @param  $mysqli MySql Connection
     * @return Echos all the Categories table
     */
    function view_all_categories($mysqli) {
        $query = "SELECT id, category_name FROM categories ORDER BY category_name ";
        $result = mysqli_query($mysqli, $query);
        ?>
        <table id="table_style">
            <thead> 
                <tr> 
                    <th><b> Category </b></th> 
                    <th align="center"><b>Number of Posts </b></th> 
                    <th align="center"><b> Edit </b></th> 
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_array($result)) { 
                    $cat_id = $row['id'];
                    ?>
                    <tr>
                        <td><strong><?php echo $row[ 'category_name' ]; ?></strong></td>
                        <td align="center" ><?php echo get_number_of_posts_category($mysqli, $cat_id); ?></td>

                        <td align="center"><a href="category-edit.php?id=<?php echo $row[ 'id' ]; ?>&edit=1">Edit</a></td>
                    </tr>
                <?php   
                } 
                ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Function to show the Head menu of Categoris Page
     * @return Echos the menu
     */
    function show_category_menu(){
        ?>
        <div class="head_menu_content">
            <a href="<?php echo PANEL_URL; ?>categories.php"> Categories </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>category-new.php">Add a category </a>
        </div>
        <?php
    }


    function show_panel(){
        ?> 
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>panel.php"> Panel </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>post-new.php"> New Post </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>categories.php"> Categories </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>category-new.php"> New Category </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>users.php"> Users </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>posts-database.php"> Post Database </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>search.php">Search</a> </div>
        <div class="menu_items"> <a href="<?php echo PHPMYADMIN_URL; ?>" target="_blank">'PHP MY Admin' </a> </div>
        <div class="menu_items"> <a href="<?php echo PANEL_URL; ?>logout.php">Log Out</a> </div>

        </br>

        <div class="menu_items"><a  href="<?php echo MAIN_URL; ?>" target="_blank"> Website - Public </a> </div>
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

    function add_user($mysqli, $username, $password, $password_repeat, $email) {
        if ($password == $password_repeat) {
            $user_password_hash = password_hash($password, PASSWORD_DEFAULT);

            if ($insert_stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)") ) {
                $insert_stmt->bind_param('sss', $username, $email, $user_password_hash);
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
        <div class="head_menu_content">
            <a  title="See all users list" href="<?php echo PANEL_URL; ?>users.php">Users</a>
            &nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>users-login-attempts.php" title="See all error logins from users">Users Login Attempts</a>
            &nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>users-new.php" title="Add a new user">Add a user</a>
            &nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>users-login-traces.php" title="Show Login Traces">Login Traces</a>
        </div>
        <?php
    }

    function view_user_menu(){
        ?>
        <div class="head_menu_content">
            <a  title="See the list of all categories" href="<?php echo PANEL_URL; ?>categories.php">Edit Profile </a>
            &nbsp;&nbsp;&nbsp;&nbsp;&#124;
            <a href="<?php echo PANEL_URL; ?>category-new.php" title="Add a new category">Add a category </a>
        </div>
        <?php
    }

    function view_single_user($mysqli, $user_id) {
        $query_select_user = "SELECT id, username, email FROM users WHERE id = $user_id";
        $result_user       = mysqli_query($mysqli, $query_select_user);
        $row_user          = mysqli_fetch_array($result_user);
        ?>
        <p>
            <strong>Name:</strong> <?php echo $row_user[ 'username' ]; ?>
        </p>
        <p>
            <strong>Email:</strong> <?php echo $row_user[ 'email' ]; ?>
        </p>
        <p>
            <strong>Number of Posts:</strong> <?php echo number_of_posts_user($mysqli, $user_id); ?>
        </p>
        <?php
    }

    function number_of_posts_user($mysqli, $user_id){
        $query_select_user = "SELECT post_author FROM posts WHERE post_author = $user_id";
        $result_user       = mysqli_query($mysqli, $query_select_user);
        $row_user          = mysqli_fetch_array($result_user);

        return count($row_user);
    }

    function show_all_users($mysqli) {

        $query_select_mem = "SELECT id, username, email FROM users";
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
                    <td align="right"><?php echo number_of_posts_user($mysqli, $data[ 'id' ]); ?></td>
                    <td align="center">
                        <a href="single-user.php?m_id=<?php echo $data[ 'id' ]; ?>" >
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

    /**
    * Get the Post's Title by ID
    * @param  $mysqli  MySql Connection
    * @param  $post_id  int
    * @return string  Title of the Post
    */
    function get_post_title($mysqli, $post_id){
        $query_title  = "SELECT post_title FROM posts WHERE id = $post_id LIMIT 1";
        $result_title = mysqli_query($mysqli, $query_title);
        $data_title   = mysqli_fetch_array($result_title);

        return $data_title[ 'post_title' ];
    }

    /**
    * Get User's username by ID
    * @param  $mysqli  MySql Connection
    * @param  $user_id  int
    * @return string  Name of the User
    */
    function get_user_name($mysqli, $user_id){
        $user_author  = "SELECT id, username FROM users WHERE id = $user_id";
        $result_user = mysqli_query($mysqli, $user_author);
        $data_user   = mysqli_fetch_array($result_user);

        return $data_user[ 'username' ];
    }

    /**
     * Gets name of the category by ID
     * @param  $mysqli  MySql Connection parameters
     * @param  $category_id  Id of the current category
     * @return string  Category name
     */
    function get_category_name($mysqli, $category_id) {
        $query_cat  = "SELECT category_name FROM categories WHERE id = $category_id";
        $result_cat = mysqli_query($mysqli, $query_cat);
        $data_cat   = mysqli_fetch_array($result_cat);

        return $data_cat[ 'category_name' ];
    }

    /**
    * @param $mysqli MySql Connections
    * @param $id
    * @param $category
    * @param $category_post_numb
    * @param $author
    * @param $mem_post_counter
     */
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
            header("Location: " . PANEL_URL ."single-post-view.php?p_id=".$post_id."&edit=success");
        }
    }

    function new_post($mysqli, $user, $title, $category, $post_status, $img_new_name ) {

        if (($title != '') && ($category != '')) {
            $query_insert_post = "INSERT INTO posts (post_author, post_title, post_status, category_id, post_photo_name)
                                       VALUES ('$user', '$title' , '$post_status', '$category', '$img_new_name')";
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

    /**
     * Shows the Single Post Page Head Menu
     * @param  $mysqli MySql Connection
     * @param  int $post_id  ID of the current post
     * @return Echos the menu
     */
    function view_single_post_menu($mysqli, $post_id) {
        $query_posts   = "SELECT id, post_status, post_date, post_views FROM posts WHERE id = $post_id";
        $result_posts  = mysqli_query($mysqli, $query_posts);
        $row_post_menu = mysqli_fetch_array($result_posts);
        ?>
        <div class="head_menu_content"  >
        <a title="Edit this post" href="post-edit.php?p_id=<?php echo $post_id; ?>">Edit</a>
            |
        <a onclick="return confirm('Press OK to delete this post. ')" href="?p_id=<?php echo $post_id; ?>&del=1" title="Delete this post">Delete</a>
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

    /**
     * Function to display Single Post's Details
     * @param  $mysqli MySql Connection
     * @param  int $post_id Id of the current post
     * @return Echos divs with the information of the post
     */
    function view_single_post($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_author, post_title, category_id, post_views, post_photo_name FROM posts WHERE  id = $post_id";
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
                    Category: </span><?php echo get_category_name($mysqli, $row_post[ 'category_id' ]); ?>
                </div>
                <div class="items">
                    <span class="post-details">
                    Author: </span><?php echo get_user_name($mysqli, $row_post['post_author'] ); ?>
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

    /**
     * Function to show the menu on the Single-Post-Image
     * @param  $mysqli MySql Connection
     * @param  int $post_id Id of the current post
     * @return Echos the menu with Delete
     */
    function view_single_post_image_menu($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_title FROM posts WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);
        ?>
        <div class="head_menu_content" style="width:491px;" >
            <span style="color:#336699; padding-left:10px"><?php echo $row_post[ 'post_title' ]; ?></span>
            <a href="single-post-view.php?p_id=<?php echo $post_id; ?>">
                <span style="float:right; margin-right:10px; color:#336699; font-weight:bold;">
                    Back
                </span>
                <img style="float:right; width:15px; margin-top:2px; margin-right:5px; height:auto;" src="images/left_arrow.png">
            </a>
        </div>
        <?php
    }

    /**
     * Function to show a current image by id
     * @param  $mysqli MySql Connection
     * @param  int $post_id Id of the current post
     * @return Echos the current image
     */
    function view_single_post_image($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_photo_name FROM posts WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);

        $img_path = UPLOADS_URL . $row_post[ 'post_photo_name' ];
        ?>
        <a href="single-post-view.php?p_id=<?php echo $row_post[ 'id' ]; ?>">
            <img class="img_view_full" title="Back to detailed view" src=<?php echo $img_path ?> />
        </a>
        <?php
    }

    /**
     * Function to show the Posts Database Table 
     * @param  $mysqli MySql Connection
     * @return Echos the table of all posts
     */
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
                <td title="View&nbsp;&nbsp; <?=$data['id'] ?>" style="text-align:center; cursor:default"><a href="single-post-view.php?p_id=<?= $data['id']; ?>" /><img src="images/open.png" class="p_db_img_view"></td>
            </tr>
      <?php  } ?>
        </tbody> 
        </table> 
    <?php
    }

    /**
     * Function to show the IP of the user
     * @return Returns the ip
     */
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

    /**
     * Function to show the left column of images on the panel
     * @param  $mysqli MySql Connection
     * @return Echos the left column of images ( form 1 to 5 )
     */
    function latest_posts_left($mysqli){

        $query_select_img = "SELECT id, post_photo_name, post_date FROM posts ORDER BY post_date DESC LIMIT 0 ,5";
        $result_img = mysqli_query($mysqli, $query_select_img); 
        
        while($row_img = mysqli_fetch_array($result_img)){
            if($row_img['post_photo_name']!=''){
                $img_path = MAIN_URL . "uploads/".$row_img['post_photo_name'];
                ?>
                <a href="view-image.php?p_id=<?php echo  $row_img['id'] ?>" >
                    <img class="panel_img_latest_left" src= "<?php echo $img_path; ?>" title="Permalink: (<?php echo MAIN_URL; ?>view-image.php?p_id=<?php echo  $row_img['id']; ?>)">
                </a>
                <?php
            } 
        }
    }

    /**
     * Function to show the right column of images on the panel
     * @param  $mysqli MySql Connection
     * @return Echos the right column of images ( form 5 to 10 )
     */
    function latest_posts_right($mysqli){

        $query_select_img = "SELECT id, post_photo_name, post_date FROM posts ORDER BY post_date DESC LIMIT 5, 10";
        $result_img = mysqli_query($mysqli, $query_select_img); 
        
        while($row_img = mysqli_fetch_array($result_img)){
            if($row_img['post_photo_name']!=''){
                $img_path = MAIN_URL . "uploads/".$row_img['post_photo_name'];
                ?>
                <a href="view-image.php?p_id=<?php echo  $row_img['id'] ?>" >
                    <img class="panel_img_latest_right" src= "<?php echo $img_path; ?>" title="Permalink: (<?php echo MAIN_URL; ?>view-image.php?p_id=<?php echo  $row_img['id']; ?>)">
                </a>
                <?php
            } 
        }
    }

?>