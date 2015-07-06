<?php 

include 'functions.php';
sec_session_start(); // Our custom secure way of starting a php session. 
 
if(isset($_POST['email'], $_POST['p'])) { 

   $email = $_POST['email'];
   $password = $_POST['p']; // The hashed password.
   $user_ip = getRealIpAddr();

      if(login($email, $password,$user_ip,$mysqli) == true) {
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