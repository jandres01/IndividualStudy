<h2>You have finished the quiz!</h2>

<?php
session_start();

if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
  echo "get on dias11";
  die();
}

if (isset($_SESSION['username']) && isset($_SESSION['userid'])) {
  $servername = "localhost";
  $username = "quizproject";
  $password = "QuizGradesDontMatter";
  $dbname = "quizproject";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

    
}

?>

<p>Somewhere around here there would probably be a button to go back to the home page</p>
