<?php

    $root = realpath(__DIR__ . '/../..');
    include "$root/config.php";

    function sec_session_start() {
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
        // All login attempts are counted from the past 2 hours.
        $valid_attempts = $now-(2*60*60);

        if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
            $stmt->bind_param('i', $user_id);
            // Execute the prepared query.
            $stmt->execute();
            $stmt->store_result();
            // If there has been more than 5 failed logins
            if ($stmt->num_rows > 5) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    function login($email, $password, $user_ip, $mysqli) {

        $check_query = "SELECT email, level FROM members WHERE email='$email' LIMIT 1";
        $adm         = mysqli_fetch_array(mysqli_query($mysqli, $check_query));

        if ($adm[ 'level' ] == 1) {
            // Using prepared Statements means that SQL injection is not possible.
            if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")) {
                $stmt->bind_param('s', $email); // Bind "$email" to parameter.
                $stmt->execute(); // Execute the prepared query.
                $stmt->store_result();
                $stmt->bind_result($user_id, $username, $db_password, $salt); // get variables from result.
                $stmt->fetch();
                $password = hash('sha512', $password.$salt); // hash the password with the unique salt.

                if ($stmt->num_rows == 1) { // If the user exists
                    // We check if the account is locked from too many login attempts
                    if (checkbrute($user_id, $mysqli) == true) {
                        // puno me kte. shif kushtet e loginit
                        echo "Account susspended";

                        // Send an email to user saying their account is locked
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
    }

    function show_member_whois($mysqli) {
        return $_SESSION[ 'username' ];
    }

    function login_check($mysqli) {

        if(isset($_SESSION[ 'user_id' ])){
            $id_user     = $_SESSION[ 'user_id' ];
            $check_query = "SELECT id, level FROM members WHERE id='$id_user' LIMIT 1";
            $adm         = mysqli_fetch_array(mysqli_query($mysqli, $check_query));

        if ($adm[ 'level' ] == 1) {
            // Check if all session variables are set
            if (isset($_SESSION[ 'user_id' ], $_SESSION[ 'username' ], $_SESSION[ 'login_string' ])) {
                $user_id      = $_SESSION[ 'user_id' ];
                $login_string = $_SESSION[ 'login_string' ];
                $username     = $_SESSION[ 'username' ];

                $user_browser = $_SERVER[ 'HTTP_USER_AGENT' ]; // Get the user-agent string of the user.

                if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
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
            $query_insert   = "INSERT INTO category (category_name) VALUES ('$cat_name')";
            $result_add_new = mysqli_query($mysqli, $query_insert);

            /*		duhet pare se shton 2 rekorde njekohsisht, exekutohet 2 here $result_add_new
                     if (!mysqli_query($mysqli,$query_insert))
                    {
                          die('Problem: ' . mysqli_error($mysqli));
                    } */
            // echo "A new category was added.";    !!! Duhet njoftuar me window jquery
            header("Location: categories.php");
        }
    }

    function show_categories($mysqli) {
        $query = "SELECT id, category_name, post_number FROM category ORDER BY id ";
        $result = mysqli_query($mysqli, $query) or die(mysqli_error());

        echo " <table id=\"table_style\" > ";
        echo " <thead> ";
        echo " <tr> ";
        echo " <th scope=\"col\"><b> Category </b></th> ";
        echo " <th scope=\"col\" align=\"center\"><b>Posts </b></th> ";
        echo " <th scope=\"col\" align=\"right\"><b> Edit </b></th> ";
        echo " <th scope=\"col\" align=\"center\"><b> Delete </b></th> ";

        echo "</th>";
        echo "</tr>";
        echo "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td title=".$row[ 'category_name' ]."&#39;s&nbsp;ID&nbsp;&nbsp;".$row[ 'id' ].">".$row[ 'category_name' ]."</td>";
            echo "<td align=\"center\" title="."Number&nbsp;of&nbsp;posts&nbsp;in&nbsp;"
                .$row[ 'category_name' ].">"
                .$row[ 'post_number' ]."</td>";

            echo "<td align=\"right\" title="."Edit&nbsp;".$row[ 'category_name' ].">
						        <a href=\"categories.php?id=".$row[ 'id' ]."&edit=1\">Edit</a></td>";
            echo "<td align=\"center\" title="."Delete&nbsp;".$row[ 'category_name' ].">
						        <a onclick=\"return confirm('Press OK to delete the Category. ')\"
						  	     href=\"categories.php?id=".$row[ 'id' ]."&del=1\">Delete</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    function show_category_menu() {
        echo "<div id=\"member_menu\"  >";
        echo "<a  title=\"See the list of all categories\" href=\"http://irishjoy.flivetech.com/panel/super/categories.php\"> Categories </a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&#124;";
        echo "<a href=\"http://irishjoy.flivetech.com/panel/super/categories-new.php\"
			        title=\"Add a new category\">Add a category </a>";

        echo "</div>";
    }


    function getNumOfCategoriesSP($mysqli, $cat_name) {
        $query_select              = "SELECT post_number FROM category WHERE category_name='$cat_name'";
        $result_fetch              = mysqli_query($mysqli, $query_select);
        $result_select_postcounter = mysqli_fetch_array($result_fetch);

        return $result_select_postcounter[ 'post_number' ];
    }

    function show_panel() {
        ?>
        <div class="menu_items"> <a href="<?php echo MAIN_URL; ?>panel/panel.php"> Panel </a> </div>
        <div class="menu_items"> <a href="<?php echo MAIN_URL; ?>panel/categories.php"> Categories </a> </div>
        <div class="menu_items"> <a href="<?php echo MAIN_URL; ?>panel/posts-database.php" target="_blank"> Post Database </a> </div>
        <div class="menu_items"> <a href="<?php echo MAIN_URL; ?>panel/panel.php">Test gallery</a> </div>
        <div class="menu_items"> <a href="<?php echo MAIN_URL; ?>panel/search.php">Search</a> </div>
        <div class="menu_items"> <a href="<?php echo GOOGLE_ANALYTICS_URL; ?>" target="_blank" > Google Analytics </a> </div>
        <div class="menu_items"> <a href="<?php echo PHPMYADMIN_URL; ?>" target="_blank">'PHP MY Admin' </a> </div>
        <div class="menu_items"> <a href="<?php echo MAIN_URL; ?>panel/panel.php">Switch to Level 2</a> </div>
        <div class="menu_items"> <a href="<?php echo EMAIL_URL; ?>" target="_blank">Check Mail</a> </div>

        </br>

        <div class="menu_items"><a  href="<?php echo MAIN_URL; ?>" target="_blank"> Website - Public </a> </div>
        <?php
    }

    function head_custom_menu() {
        echo "<div style=\"float:right; margin-right: 30px;\">";

        echo "<button id=\"custom_menu_button\"syle=\"width:80px;\" class=\"custom_menu\" >";
        echo "<img style=\"margin-right:3px\" src=\"images/gear.png\" border=0 width=\"15px\" height=\"15px\">";
        echo "Panel </img></button>";

        echo "<a href=\"http://irishjoy.flivetech.com/panel/super/members.php\" style=\"text-decoration:none;\">";
        echo "<div id=\"custom_menu1\" style=\"border-radius:3px 3px 0px 0px;\"> ";
        echo "<img style=\"margin-right:3px;\"
					      src=\"images/members_custom.png\" border=0 width=\"15px\" height=\"15px\">Members </div>";
        echo "</a>";

        echo "<a href=\"http://irishjoy.flivetech.com/panel/super/advertises.php\" style=\"text-decoration:none;\">";
        echo "<div id=\"custom_menu2\" > ";
        echo "<img style=\"margin-right:3px\"
				          src=\"images/advertise.png\" border=0 width=\"15px\" height=\"15px\"> Advertises </img></div></a>";

        echo "<a href=\"http://irishjoy.flivetech.com/panel/super/logout.php\" style=\"text-decoration:none;\"> ";
        echo "<div id=\"custom_menu3\" style=\"border-radius:0px 0px 3px 3px;\">";
        echo "<img style=\"margin-right:3px\"
						  src=\"images/logout.png\" border=0 width=\"15px\" height=\"15px\"> Logout </img></div></a>";

        echo "</div>";
    }

    function show_login_attempts($mysqli) {

        $query_select_mem = "SELECT user_id, act_time,ip FROM login_attempts ORDER BY act_time DESC ";
        $result_mem       = mysqli_query($mysqli, $query_select_mem);

        echo " <table id=\"table_style\"> ";
        echo " <thead> ";
        echo " <tr> ";
        echo " <th scope=\"col\" align=\"center\"><b> Member ID </b></th> ";
        echo " <th scope=\"col\" align=\"center\"><b>Time</b></th> ";
        echo " <th scope=\"col\" align=\"center\"><b>IP</b></th> ";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($data = mysqli_fetch_array($result_mem)) {
            echo "<tr>";
            echo "<td align=\"center\" >".$data[ 'user_id' ]." </td>";
            echo "<td align=\"center\" title=\"".(date("l, d F  H:i", strtotime($data[ 'act_time' ])))." \">"
                .(date("d.m.Y - H:i", strtotime($data[ 'act_time' ])));
            " </td>";
            echo "<td align=\"center\" >".$data[ 'ip' ]." </td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

    }

    function show_member_login_traces($mysqli) {
        $query_select_trace = "SELECT id, member_email, time, ip FROM login_filter ORDER BY id DESC";
        $result_trace_login = mysqli_query($mysqli, $query_select_trace);


        echo "<table cellspacing=\"1\" class=\"tablesorter\" style=\"cursor: default;\">";
        echo "<thead> ";
        echo "<tr> ";
        echo "<th>&nbsp;U / Email</th> ";
        echo "<th style=\"text-align:center; \">Time</th>";
        echo "<th style=\"text-align:center; \">IP</th> ";
        echo "</tr> ";
        echo "</thead> ";
        echo "<tbody> ";

        while ($data = mysqli_fetch_array($result_trace_login)) {
            echo "<tr>";
            echo "<td>"."&nbsp;".substr($data[ 'member_email' ], 0, 30)." </td>";
            echo "<td title=\"".(date("l, d F  H:i", strtotime($data[ 'time' ])))." \"
						style=\"text-align:center; \">".(date("d.m.Y - H:i", strtotime($data[ 'time' ])));
            " </td>";
            echo "<td style=\"text-align:center; \">".$data[ 'ip' ]." </td>";
            echo "</tr>";
        }
        echo "</tbody> ";
        echo "</table> ";

    }

    function add_member($mysqli, $username, $password, $email) {
        if ($username != '' and $password != '' and $email != '') {
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $password    = hash('sha512', $password.$random_salt);

            if ($insert_stmt = $mysqli->prepare
                ("INSERT INTO members (username, email, password, salt) VALUES (?, ?, ?, ?)")
            ) {
                $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
                // Execute the prepared query.
                $insert_stmt->execute();
            }
        }
    }

    function delete_member($mysqli, $id) {
        $query_del = "DELETE FROM members WHERE id=$id";
        $result_del = mysqli_query($mysqli, $query_del)
        or
        die('Problem: '.mysqli_error($mysqli));
    }

    function show_member_menu() {
        echo "<div id=\"member_menu\"  >";
        echo "<a  title=\"See all members list\" href=\"http://irishjoy.flivetech.com/panel/super/members.php\"> Members </a>";
        echo "&nbsp;&nbsp;&#124;";
        echo "<a href=\"http://irishjoy.flivetech.com/panel/super/members-login-attempts.php\"
			        title=\"See all error logins from members\">Members Login Attempts </a>";
        echo "&nbsp;&nbsp;&#124;";
        echo "<a  href=\"http://irishjoy.flivetech.com/panel/super/members-new.php\"
					 title=\"Add a new member\">Add a member </a>";
        echo "&nbsp;&nbsp;&#124;";
        echo "<a  href=\"http://irishjoy.flivetech.com/panel/super/members-login-traces.php\"
					 title=\"Show Login Traces\">Login Traces</a>";
        echo "</div>";
    }

    function view_member_menu() {
        echo "<div id=\"member_menu\"  >";
        echo "<a  title=\"See the list of all categories\" href=\"http://irishjoy.flivetech.com/panel/super/categories.php\">
			Edit Profile </a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&#124;";
        echo "<a href=\"http://irishjoy.flivetech.com/panel/super/categories-new.php\"
			        title=\"Add a new category\">Add a category </a>";

        echo "</div>";
    }

    function view_member($mysqli, $member_id) {
        $query_select_member = "SELECT id, username, email FROM members WHERE id = $member_id";
        $result_member       = mysqli_query($mysqli, $query_select_member);
        $row_member          = mysqli_fetch_array($result_member);


        echo "Name: ".$row_member[ 'username' ]." ";
        echo "</br>";
        echo "Email: ".$row_member[ 'email' ]." ";
        echo "</br>";


    }

    function show_members($mysqli) {
        /*
        Bejme nje query per te zgjedhur te gjithe menaxheret qe jane thjeshte admin dhe
        jo super admin.
        */
        $query_select = ("SELECT post_counter FROM members");
        $result_fetch = mysqli_query($mysqli, $query_select);

        $query_select_mem = "SELECT id, username, email FROM members ORDER BY id";
        $result_mem       = mysqli_query($mysqli, $query_select_mem);

        echo " <table id=\"table_style\"> ";
        echo " <thead> ";
        echo " <tr> ";
        echo " <th scope=\"col\"><b> Username </b></th> ";
        echo " <th scope=\"col\"><b> Email </b></th> ";
        echo " <th scope=\"col\" align=\"right\"><b>Posts</b></th> ";
        echo " <th scope=\"col\" align=\"center\"><b> View </b></th> ";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($data = mysqli_fetch_array($result_mem)) {
            $post_nr = mysqli_fetch_array($result_fetch);
            echo "<tr>";
            echo "<td title="."Member&nbsp;ID:&nbsp;".$data[ 'id' ].">".$data[ 'username' ]." </td>";
            echo "<td>".$data[ 'email' ]." </td>";
            echo "<td align=\"right\">".$post_nr[ 'post_counter' ]."  </td>";
            echo "<td align=\"center\" title="."View&nbsp;".$data[ 'username' ]."&#39;s&nbsp;profile".">
					  <a href=\"member-view.php?m_id=".$data[ 'id' ]."\">
					  <img src=\"images/member.png\" border=0 width=\"15\" height=\"15\"></a></td>";


            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }


    function show_statistics($mysqli) {
        $query_categories  = "SELECT category_name FROM category";
        $categories_result = mysqli_query($mysqli, $query_categories);
        $category_amount   = mysqli_num_rows($categories_result);


        $query_posts  = "SELECT id FROM post";
        $posts_result = mysqli_query($mysqli, $query_posts);
        $post_amount  = mysqli_num_rows($posts_result);

        $query_members  = "SELECT id FROM members";
        $members_result = mysqli_query($mysqli, $query_members);
        $members_amount = mysqli_num_rows($members_result);

        echo " <table id=\"table_style\"> ";
        echo " <thead> ";
        echo " <tr> ";
        echo " <th scope=\"col\"><b> Items </b></td>";
        echo " <th scope=\"col\"><b> Amount </b></td>";
        echo " </tr> ";
        echo " </thead> ";

        echo "<tbody>";
        echo " <tr> ";
        echo " <td><b> Posts </b></td> ";
        echo " <td> $post_amount </td> ";
        echo " </tr> ";

        echo " <tr> ";
        echo " <td><b> Categories </b></td> ";
        echo " <td> $category_amount </td> ";
        echo " </tr> ";

        echo " <tr> ";
        echo " <td><b> Members </b></td> ";
        echo " <td> $members_amount </td> ";
        echo " </tr> ";

        echo "</tbody>";
        echo "</table>";

    }

    function upload_image($img_name, $img_size, $tmp) {
        // duhet futur kushti qe shef a esht apo jo img nisur nga prapashtesa

        if ($img_size < 1024*1024*2) // size < 2MB
        {
            // emrit i shtohet nje nr random qe mos ngaterrohet
            $img_new_name = rand(00, 9999).strtolower(str_replace(' ', '-', $img_name));

            if (move_uploaded_file($tmp, SERVER_URL.'tagged/'.$img_new_name)) {
                echo '<p>The image was updated successfully</p>';

                return $img_new_name;
            }
            else {
                echo '<p>There was a problem during upload. Please try again.</p>';

            }
        }
    }

    function getNumOfPosts($mysqli, $member) {
        $query_select              = "SELECT post_counter FROM members WHERE username='$member'";
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
        $query_del  = "DELETE FROM post WHERE id=$id";
        $result_del = mysqli_query($mysqli, $query_del);

        $query_update              = ("UPDATE category
							SET post_number='$category_post_numb'
							WHERE category_name='$category'");
        $result_update_postcounter = mysqli_query($mysqli, $query_update);

        $query_update              = ("UPDATE members
							SET post_counter='$mem_post_counter'
							WHERE username='$author'");
        $result_update_postcounter = mysqli_query($mysqli, $query_update);

    }

    function edit_post($mysqli, $post_id, $title, $category) {
        //Nese nuk ka input tek titulli dhe kategoria, nuk shtohet
        if( ($title != " "))
        {
            $query_update_post  = "UPDATE post SET post_title='$title', post_category='$category' WHERE id=$post_id";
            $result_update_post = mysqli_query($mysqli, $query_update_post);
            header("Location: http://irishjoy.flivetech.com/panel/super/post-view.php?p_id=".$post_id."&edit=success");
        }
    }

    function new_post($mysqli, $member, $title, $category, $visibility, $img_new_name, $post_number, $category_numb) {
        //Nese nuk ka input tek titulli dhe kategoria, nuk shtohet
        if (($title != '') && ($category != '')) {
            $query_insert_post = "INSERT INTO post (post_author, post_title, post_status, post_category, post_photo_name)
								       VALUES ('$member', '$title' , '$visibility', '$category', '$img_new_name')
								 ";
            $result_add_post   = mysqli_query($mysqli, $query_insert_post);

            $query_update              = ("UPDATE members
								SET post_counter='$post_number'
								WHERE username='$member'");
            $result_update_postcounter = mysqli_query($mysqli, $query_update);

            $query_update              = ("UPDATE category
								SET post_number='$category_numb'
								WHERE category_name='$category'");
            $result_update_postcounter = mysqli_query($mysqli, $query_update);

            echo '<p>New post has been added. </p>';

            /*		duhet pare se shton 2 rekorde njekohsisht, exekutohet 2 here $result_add_new
                     if (!mysqli_query($mysqli,$query_insert))
                    {
                          die('Problem: ' . mysqli_error($mysqli));
                    } */
            // echo "A new category was added.";    !!! Duhet njoftuar me window jquery
            // header("Location: post-new.php");
        }
    }

    function view_post_menu($mysqli, $id) {
        $query_posts   = "SELECT id, post_status, post_date, post_views FROM post WHERE id = $id";
        $result_posts  = mysqli_query($mysqli, $query_posts);
        $row_post_menu = mysqli_fetch_array($result_posts);

        echo "<div id=\"member_menu\"  >";
        echo "<a  title=\"Edit this post\"
					  href=\"post-edit.php?p_id=$id\">Edit</a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&#124;";
        echo "<a onclick=\"return confirm('Press OK to delete this post. ')\"
					href=\"?p_id=$id&del=1\"
			        title=\"Delete this post\">Delete</a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&#124;";
        echo "<a  title=\"Add a new post\" href=\"post-new.php\">New Post</a>";
        echo "<span title=\"".(date("l, d F, H:i", strtotime($row_post_menu[ 'post_date' ])))." \"
			style=\"margin-left:50px; color:#336699; cursor:default;\">"
            .(date("d.m.Y - H:i", strtotime($row_post_menu[ 'post_date' ])));
        " ";
        echo "</span>";
        if ($row_post_menu[ 'post_status' ] == '1') {
            echo "<span style=\"float:right; margin-right:10px; cursor:default; color:#008000; font-weight:bold;\">";
            echo "Published";
            echo "</span>";
        }
        else {
            echo "<span style=\"float:right; margin-right:10px; color:#AF0000; font-weight:bold;\">";
            echo "Not Published";
            echo "</p>";
        }
        echo "</div>";
    }


    function view_post($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_author, post_title, post_category, post_views,
								   post_photo_name FROM post WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);

        if ($row_post[ 'post_title' ] == '') {
            echo "<div style=\"color:red; font-weight:bold;\">";
            echo "This post may not exist!";
            echo "</div>";
        }
        else {
            echo "<div style=\"width:300px; float:left;\"  >";
            echo "<span style=\"color:#336699; font-weight:bold;\">
			 Title: "."</span>".$row_post[ 'post_title' ]." ";
            echo "</br>";
            echo "</br>";
            echo "<span style=\"color:#336699; font-weight:bold;\">
			 Img Name: "."</span>".$row_post[ 'post_photo_name' ]." ";
            echo "</br>";
            echo "</br>";
            echo "<span style=\"color:#336699; font-weight:bold;\">
			 Category: "."</span>".$row_post[ 'post_category' ]." ";
            echo "</br>";
            echo "</br>";
            echo "<span style=\"color:#336699; font-weight:bold;\">
			 Author: "."</span>".$row_post[ 'post_author' ]." ";
            echo "</br>";
            echo "</br>";
            echo "<span style=\"color:#336699; font-weight:bold;\">
			 Views: "."</span>"."<b>".$row_post[ 'post_views' ]."</b>"." ";
            echo "</br></br></br>";
            echo "</br>";
            echo "<a href=\"posts-database.php\" style=\"text-decoration:none; color:#336699\">
			 <img style=\"width:15px; margin-bottom:-3px; height:auto;\"src=\"images/left_arrow.png\">Go to database.</img></a>";
            $img_path = "http://irishjoy.flivetech.com/tagged/".$row_post[ 'post_photo_name' ];
            if ($row_post[ 'post_photo_name' ] == '') {
                echo "</div>";
                echo "<p style=\"width:200px; float:right; color:red; font-weight:bold;\">";
                echo "This image cannot be found!";
                echo "</p>";
            }
            else {
                echo "</div>";
                echo "<a href=\"view-image.php?p_id=".$row_post[ 'id' ]."\" ><img class=\"post_view_img\" title=\"View full image\" src= \"$img_path\" /></a>";

            }
        }

    }

    function view_image_menu($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_title FROM post WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);

        echo "<div id=\"member_menu\" style=\"width:491px;\" >";
        echo "<span style=\"color:#336699; padding-left:10px\">".$row_post[ 'post_title' ]." </span>";
        echo "<a href=\"post-view.php?p_id=".$post_id."\">";
        echo "<span style=\"float:right; margin-right:10px; color:#336699; font-weight:bold;\">";
        echo "Back";
        echo "</span>";
        echo "<img style=\"float:right; width:15px; margin-top:2px; margin-right:5px; height:auto;\"src=\"images/left_arrow.png\">";
        echo "</a>";


        echo "</div>";
    }

    function view_image($mysqli, $post_id) {
        $query_select_posts = "SELECT id, post_photo_name FROM post WHERE id = $post_id";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);
        $row_post           = mysqli_fetch_array($result_posts);

        $img_path = "http://irishjoy.flivetech.com/tagged/".$row_post[ 'post_photo_name' ];
        //echo "<img class=\"img_view_full\" src= \"$img_path\" />";
        echo "<a href=\"post-view.php?p_id=".$row_post[ 'id' ]."\" ><img class=\"img_view_full\" title=\"Back to detailed view\" src= \"$img_path\" /></a>";
    }

    function show_posts_database($mysqli) {
        $query_select_posts = "SELECT id, post_author, post_date, post_title, post_status, post_category, post_views, post_photo_name FROM post ORDER BY id DESC";
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
                <td> <?= $data['post_category']; ?> </td>
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


    function getRealIpAddr() {
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