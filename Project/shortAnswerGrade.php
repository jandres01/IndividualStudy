<h2>The grades for these short answer questions have been input into the database!!</h2>

<?php
session_start();

if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
  echo "get on dias11";
  die();
}

if (isset($_SESSION['studentname']) && isset($_SESSION['studentid'])) {
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
 
    if ($conn->query("SELECT id FROM shortAnswerScore WHERE id=" . $_SESSION['studentid'] . ";")->num_rows == 0) {
      $quest_ids = array_keys($_REQUEST);
  
      $sqlBase = "INSERT INTO shortAnswerScore (uid, quizid, questid, grade) values ";
      foreach ($quest_ids as $id) {
        if ($_REQUEST[$id] <= 20 && $_REQUEST[$id] >= 0) {
          $sql = $sqlBase . "(" . $_SESSION['studentid'] . ", " . $_SESSION["quiz"] . ", " . $id . ", " . ($_REQUEST[$id]/20 * 100) . ");";
          $conn->query($sql);
        }
      }

      $sql = "SELECT avg(grade) AS avg, count(*) AS cnt FROM shortAnswerScore WHERE uid=" . $_SESSION['studentid'] . ";";
      $result1 = $conn->query($sql)->fetch_assoc();
      $sql = "INSERT INTO shortAnswerScore (uid, quizid, questid, grade) values (" . $_SESSION['studentid'] . ", " . $_SESSION['quiz'] . ", 0, " . $result1['avg'] . ");";
      $conn->query($sql);

      $sql = "SELECT avg(grade) AS avg, count(*) AS cnt FROM multChoiceScore WHERE uid=" . $_SESSION['studentid'] . ";";
      $result2 = $conn->query($sql)->fetch_assoc();

      $total = $result1["cnt"] + $result2["cnt"];
      $avg = ($result1["cnt"]/$total * $result1["avg"]) + ($result2["cnt"]/$total * $result2["avg"]);
      $sql = "INSERT INTO scores (pct, user_id, quiz_id) VALUE (" . $avg . ", " . $_SESSION['studentid'] . ", " . $_SESSION['quiz'] . ");";
      $conn->query($sql);
    } else {
      echo "<p>There is something already in the database</p>";
    }
    header("Location: editQuiz.php");
  }
}
?>
