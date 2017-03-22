<?php
session_start();

session_unset();
#session_destroy();

$_SESSION["quiz"] = 1;
$_SESSION["questtype"] = "sa";
$_SESSION["questnum"] = 0;

header('Location: ./multchoice.php');
?>
