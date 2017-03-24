<?php
session_start();

session_unset();
#session_destroy();

$_SESSION["quiz"] = 1;
$_SESSION["questtype"] = "mc";
$_SESSION["questnum"] = 0;
$_SESSION["username"] = "poop face mgee";
$_SESSION["userid"] = 4;

header('Location: ./quizView.php');
?>
