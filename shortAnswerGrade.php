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
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r(array_keys($_REQUEST));
    echo "<br>";;
    print_r($_REQUEST);
    echo "<br><br>";
 
    if ($conn->query("SELECT id FROM shortAnswerScore WHERE id=" . $_SESSION['userid'] . ";")->num_rows == 0) {
      $quest_ids = array_keys($_REQUEST);
  
      $sqlBase = "INSERT INTO shortAnswerScore (uid, quizid, questid, grade) values ";
      foreach ($quest_ids as $id) {
        if ($_REQUEST[$id] <= 20 && $_REQUEST[$id] >= 0) {
          $sql = $sqlBase . "(" . $_SESSION['userid'] . ", " . $_SESSION["quiz"] . ", " . $id . ", " . ($_REQUEST[$id]/20 * 100) . ");";
          $result = $conn->query($sql);
        }
      }
    } else {
      echo "<p>There is something already in the database</p>";
    }
    #header("Location:"); =========================================================================================================
  }
}
?>
