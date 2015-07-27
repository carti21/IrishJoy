<?php 

   require_once('functions.php');
   
   sec_session_start(); // Our custom secure way of starting a php session. 
    
   if(isset($_POST['email'], $_POST['password'])) { 

      $email = $_POST['email'];
      $password = $_POST['password']; // The hashed password.
      $user_ip = getRealIpAddr();

         if(login($mysqli, $email, $password) == true) {
            // Login success
            header('Location: ./panel.php');
         } else {
            // Login failed
            header('Location: ./login.php?error=1');
         }
   } else { 
      // The correct POST variables were not sent to this page.
      echo 'Invalid Request';
   }