<h2>You have finished the quiz!</h2>

<?php
session_start();

if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
  echo "get on dias11";
  die();
}

if (isset($_SESSION["student_id"])) {
  $servername = "localhost";
  $username = "quizproject";
  $password = "QuizGradesDontMatter";
  $dbname = "quizproject";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if (isset($_SESSION["quizID"])) {
    $sql = "SELECT count(*) AS total FROM multChoice WHERE quizNum=" . $_SESSION['quizID'] . ";";
    $result = $conn->query($sql)->fetch_assoc();
    $total = $result["total"];

    $sql = "SELECT count(*) AS correct FROM multChoice, multChoiceAnswer WHERE multChoiceAnswer.quest_id = multChoice.id && multChoiceAnswer.ans = multChoice.ans && multChoice.quizNum=" . $_SESSION['quizID'] . " && multChoiceAnswer.user_id=" . $_SESSION['student_id'] . ";";
    $result = $conn->query($sql)->fetch_assoc();
    $correct = $result["correct"];

    $sql = "INSERT INTO multChoiceScore (uid, quizid, grade) VALUE (" . $_SESSION['student_id'] . ", " . $_SESSION['quizID'] . ", " . ($correct/$total * 100) . ");";
    $conn->query($sql);

    $sql = "INSERT INTO hasTaken (user_id, quiz_id) VALUE (" . $_SESSION['student_id'] . ", " . $_SESSION['quizID'] . ");";
    $conn->query($sql);

    unset($_SESSION["quizID"]);
    unset($_SESSION["questtype"]);
    unset($_SESSION["questnum"]);
  }
}

?>

<a href="./verifyUser.php">Go back to the home page</a>
