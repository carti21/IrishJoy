<?php 

   require_once('functions-admin.php');
   
   sec_session_start();
    
   if(isset($_POST['email'], $_POST['password'])) { 

      $email = $_POST['email'];
      $password = $_POST['password'];

         if(login($mysql_conn, $email, $password) == true) {
            // Login success
            header('Location: ./index.php');
         } else {
            // Login failed
            header('Location: ./login.php?error=1');
         }
   } else { 
      // The correct POST variables were not sent to this page.
      echo 'Invalid Request';
   }