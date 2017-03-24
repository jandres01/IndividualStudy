<?php
   session_start();

   session_unset();

   echo 'You have chosen to logout from session';
   header('Refresh: 0; URL = projectLogin.html');

?>
