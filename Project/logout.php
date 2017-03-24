<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   
   echo 'You have chosen to logout from session';
   header('Refresh: 0; URL = projectLogin.html');

?>
