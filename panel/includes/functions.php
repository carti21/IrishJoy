<?php
    
    define("MAIN_URL", "localhost/irishjoy/");

    function sec_session_start() {
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure       = false; // Set to true if using https.
        $httponly     = true; // This stops javascript being able to access the session id.
        $lifecookie   = 60*10; // Sa do zgjase cookie

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


        $mysqli->query("INSERT INTO login_filter (member_email,ip) VALUES ('$email','$user_ip')");
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

    function show_member_whois($mysqli) {
        return $_SESSION[ 'username' ];
    }

    function login_check($mysqli) {
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

    function show_statistics($mysqli) {
        $query_categories  = "SELECT category_name FROM category";
        $categories_result = mysqli_query($mysqli, $query_categories);
        $category_amount   = mysqli_num_rows($categories_result);


        $query_posts  = "SELECT id FROM post";
        $posts_result = mysqli_query($mysqli, $query_posts);
        $post_amount  = mysqli_num_rows($posts_result);

        echo " <table id=\"table_style\" style=\"width:300px; margin-bottom:0px;\"> ";
        echo " <thead> ";
        echo " <tr> ";
        echo " <th scope=\"col\"><b> Statistics </b></td>";
        echo " <th scope=\"col\"></td>";
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


        echo "</tbody>";
        echo "</table>";

    }

    function show_categories($mysqli) {
        $query = "SELECT id, category_name, post_number FROM category ORDER BY id ";
        $result = mysqli_query($mysqli, $query) or die(mysqli_error());

        echo " <table id=\"table_style\" > ";
        echo " <thead> ";
        echo " <tr> ";
        echo " <th scope=\"col\"><b> Category </b></th> ";
        echo " <th scope=\"col\" align=\"center\"><b>Numb of Posts </b></th> ";
        echo "</th>";
        echo "</tr>";
        echo "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td title=".$row[ 'category_name' ]."&#39;s&nbsp;ID&nbsp;&nbsp;".$row[ 'id' ].">".$row[ 'category_name' ]."</td>";
            echo "<td align=\"center\" title="."Number&nbsp;of&nbsp;posts&nbsp;in&nbsp;"
                .$row[ 'category_name' ].">"
                .$row[ 'post_number' ]."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }


    function getNumOfCategoriesSP($mysqli, $cat_name) {
        $query_select              = ("SELECT post_number FROM category WHERE category_name='$cat_name'");
        $result_fetch              = mysqli_query($mysqli, $query_select);
        $result_select_postcounter = mysqli_fetch_array($result_fetch);

        return $result_select_postcounter[ 'post_number' ];
    }

    function show_panel() {

        echo "<div id=\"menu_items\"><a  href=\"http://irishjoy.com/panel/panel.php\"> Panel </a></div>";
        echo "<div id=\"menu_items\"><a  href=\"http://irishjoy.com/panel/categories.php\"> Categories </a></div>";
        echo "<div id=\"menu_items\"><a  href=\"http://irishjoy.com/panel/posts-database.php\"> Post Database </a></div>";
        echo "<div id=\"menu_items\"><a  href=\"http://irishjoy.com/panel/gallery.php\"> All Images </a></div>";
        echo "<div id=\"menu_items\"><a  href=\"http://irishjoy.com/panel/search.php\" >Search</a></div>";

        echo '</br>';

        echo "<div id=\"menu_items\"><a  href=\"http://irishjoy.com\" target=\"_blank\"> Website - Public </a></div>";

    }

    function head_custom_menu() {
        echo "<div style=\"float:right; margin-right: 30px;\">";

        echo "<button id=\"custom_menu_button\"syle=\"width:80px;\" class=\"custom_menu\" >";
        echo "<img style=\"margin-right:3px\" src=\"images/gear.png\" border=0 width=\"15px\" height=\"15px\">";
        echo "Panel </img></button>";

        echo "<a href=\"http://irishjoy.com/panel/profile.php\" style=\"text-decoration:none;\">";
        echo "<div id=\"custom_menu1\" style=\"border-radius:3px 3px 0px 0px;\"> ";
        echo "<img style=\"margin-right:3px; margin-bottom:-2px;\"
					      src=\"images/members_custom.png\" border=0 width=\"15px\" height=\"15px\">Profile </div>";
        echo "</a>";

        echo "<a href=\"http://irishjoy.com/panel/contact.php\" style=\"text-decoration:none;\">";
        echo "<div id=\"custom_menu2\" > ";
        echo "<img style=\"margin-right:3px; margin-bottom:-2px;\"
				          src=\"images/contact_custom.png\" border=0 width=\"15px\" height=\"15px\"> Contact </img></div></a>";

        echo "<a href=\"http://irishjoy.com/panel/logout.php\" style=\"text-decoration:none;\"> ";
        echo "<div id=\"custom_menu3\" style=\"border-radius:0px 0px 3px 3px;\">";
        echo "<img style=\"margin-right:3px\"
						  src=\"images/logout.png\" border=0 width=\"15px\" height=\"15px\"> Logout </img></div></a>";

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

        $ad               = 2;
        $query_select_mem = "SELECT id, username, email FROM members WHERE id>$ad ORDER BY id";
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


    function upload_image($img_name, $img_size, $tmp) {
        // duhet futur kushti qe shef a esht apo jo img nisur nga prapashtesa

        if ($img_size < 1024*1024*2) // size < 2MB
        {
            // emrit i shtohet nje nr random qe mos ngaterrohet
            $img_new_name = rand(00, 9999).strtolower(str_replace(' ', '-', $img_name));

            if (move_uploaded_file($tmp, '../tagged/'.$img_new_name)) {
                echo '<p>The image was updated successfully</p>';

                return $img_new_name;
            }
            else {
                echo '<p>There was a problem during upload. Please try again.</p>';

            }
        }
    }

    function getNumOfPosts($mysqli, $member) {
        $query_select              = ("SELECT post_counter FROM members WHERE username='$member'");
        $result_fetch              = mysqli_query($mysqli, $query_select);
        $result_select_postcounter = mysqli_fetch_array($result_fetch);

        return $result_select_postcounter[ 'post_counter' ];
    }

    function getNumOfPostsCategory($mysqli, $category) {
        $query_select              = ("SELECT post_number FROM category WHERE category_name='$category'");
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


    function edit_post($mysqli, $post_id, $title) {
        //Nese nuk ka input tek titulli dhe kategoria, nuk shtohet
       if (($title != '') /* && ($category != '')*/) {
            $query_update_post  = "UPDATE post SET post_title='$title' WHERE id=$post_id";
            mysqli_query($mysqli, $query_update_post);
            header("Location: irishjoy.com/post-view.php?p_id=".$post_id);
            echo"editmi u krye me sukses";
        }
    }

    function new_post($mysqli, $member, $title, $category, $visibility, $img_new_name, $post_number, $category_numb) {
        //Nese nuk ka input tek titulli dhe kategoria, nuk shtohet
        if (($title != '') && ($category != '')) {
            $query_insert_post = "INSERT INTO post (post_author, post_title, post_status, post_category, post_photo_name)
								       VALUES ('$member', '$title' , '$visibility', '$category', '$img_new_name')
								 ";
            $result_add_post   = mysqli_query($mysqli, $query_insert_post);

            $query_update = ("UPDATE members SET post_counter='$post_number' WHERE username='$member'");
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
        $query_select_posts = "SELECT id, post_title, post_category, post_views,
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
			 Views: "."</span>".$row_post[ 'post_views' ]." ";
            echo "</br></br></br>";
            echo "</br>";
            echo "<a href=\"posts-database.php\">
			 <img style=\"width:15px; margin-bottom:-3px; height:auto;\"src=\"images/left_arrow.png\">Go back to database.</img></a>";
            $img_path = "http://irishjoy.com/tagged/".$row_post[ 'post_photo_name' ];
            if ($row_post[ 'post_photo_name' ] == '') {
                echo "</div>";
                echo "<p style=\"width:200px; float:right; color:red; font-weight:bold;\">";
                echo "This image cannot be found!";
                echo "</p>";
            }
            else {
                echo "</div>";
                echo "<img class=\"post_view_img\" src= \"$img_path\" />";
            }
        }

    }


    function ($mysqli) {
        $query_select_posts = "SELECT id, post_date, post_title, post_status, post_category, post_views,
								   post_photo_name FROM post ORDER BY id DESC";
        $result_posts       = mysqli_query($mysqli, $query_select_posts);


        echo "<table cellspacing=\"1\" class=\"tablesorter\">";
        echo "<thead> ";
        echo "<tr> ";
        echo "<th>Post title / Description</th> ";
        echo "<th>Date</th>";
        echo "<th>Category</th> ";
        echo "<th title=\"Published / Unpublished \">P/U &nbsp;&nbsp;</th>";
        echo "<th>Image Name</th>";
        echo "<th>Views</th>";
        echo "<th>Press</th>";
        echo "</tr> ";
        echo "</thead> ";
        echo "<tbody> ";

        while ($data = mysqli_fetch_array($result_posts)) {
            echo "<tr>";
            echo "<td style=\"cursor: default;\"
	           	    		  title=".$data[ 'post_title' ].">".substr($data[ 'post_title' ], 0, 40)." </td>";
            echo "<td title=\"".(date("l, d F  H:i", strtotime($data[ 'post_date' ])))." \"
						style=\"text-align:center; cursor: default;\">".(date("d.m.Y - H:i", strtotime($data[ 'post_date' ])));
            " </td>";
            echo "<td>".$data[ 'post_category' ]." </td>";
            echo "<td style=\"text-align:center; cursor: default;\" title="."Id&nbsp;&nbsp;".$data[ 'id' ].">"
                .$data[ 'post_status' ]." </td>";
            echo "<td style=\"cursor: default;\"
							   title=".$data[ 'post_photo_name' ].">".substr($data[ 'post_photo_name' ], 0, 15)." </td>";
            echo "<td style=\"text-align:right;\" >".$data[ 'post_views' ]." </td>";
            echo "<td style=\"text-align:center; \">"
                ."<a href=\"post-view.php?p_id=".$data[ 'id' ]."\" />"
                ."<img src=\"images/open.png\" class=\"p_db_img_view\">"." </td>";
            echo "</tr>";
        }
        echo "</tbody> ";
        echo "</table> ";

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