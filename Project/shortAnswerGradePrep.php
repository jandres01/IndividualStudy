<?php
session_start();

session_unset();
#session_destroy();

$_SESSION["quiz"] = 1;
$_SESSION["studentname"] = "big dick mgee";
$_SESSION["studentid"] = 3;
?>

<form id="grading" method="post" action="./shortAnswerGrade.php">
  <p>Short answer 1: <input id="gradeInput" type="text" name=1></p>
  <p>Short answer 2: <input id="gradeInput" type="text" name=2></p>
  <input type="submit" value="Submit">
</form>
