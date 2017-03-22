<?php
session_start();

$_SESSION["quiz"] = 1;
$_SESSION["questtype"] = "mc";
$_SESSION["questnum"] = 1;

header('Location: ./multchoice.php');
?>
