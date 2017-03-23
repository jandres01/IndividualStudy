<?php
session_start();

if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
  echo "get on dias11";
  die();
}

$servername = "localhost";
$username = "quizproject";
$password = "QuizGradesDontMatter";
$dbname = "quizproject";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Quiz " . $_SESSION["quiz"] . " - Question " . ($_SESSION["questnum"]+1) . "</h2>";

echo '<body id="quiz">QUESTION:<br>';

#if (isset($_SESSION['username']) && isset($_SESSION['userid'])) {
  #if ($_SERVER["REQUEST_METHOD"] == "POST") {
  #  $answer = $_REQUEST['answer'];
  #  $userid = $_SESSION['studentid'];
  #  if ($_SESSION["questtype"] == "mc") {
  #    $sql = "INSERT INTO multChoiceAnswer (ans, user_id, quest_id, quiz_id) VALUES (" . $answer . ", " . $userid . ", " . $_SESSION["prevQid"] . ", " . $_SESSION["quiz"] . ");";
  #    $conn->query($sql);
  #  } else {
  #    $sql = "INSERT INTO shortAnsAnswer (ans, user_id, quest_id, quiz_id) VALUES (" . $answer . ", " . $userid . ", " . $_SESSION["prevQid"] . ", " . $_SESSION["quiz"] . ");";
  #    $conn->query($sql);
  #  }
  #}
  
  if (isset($_SESSION["quiz"]) && isset($_SESSION["questtype"]) && isset($_SESSION["questnum"])) {
    if ($_SESSION["questtype"] == "mc") {
      $sql = "SELECT * FROM multChoice WHERE quizNum=" . $_SESSION["quiz"] . " LIMIT " . $_SESSION["questnum"] . ", 1;";
      $prelimResult = $conn->query($sql);
      $result = $prelimResult->fetch_assoc();

      if ($prelimResult->num_rows < 1) {
        $_SESSION["questtype"] = "sa";
        $_SESSION["questnum"] = 0;
        
        header('Location: ./multchoice.php');
        die();
      }

      $_SESSION['prevQid'] = $result['id'];

      echo '<p id="question">' . $result["question"] . "</p>";
      echo '<form id="answer" method="post" action="./multchoice.php">';
      if ( !empty($result["choice1"]) ) {
        echo '<input type="radio" name="answer" value="a" checked>' . $result["choice1"] . '<br>';
      }
      if ( !empty($result["choice2"]) ) {
        echo '<input type="radio" name="answer" value="b">' . $result["choice2"] . '<br>';
      }
      if ( !empty($result["choice3"]) ) {
        echo '<input type="radio" name="answer" value="c">' . $result["choice3"] . '<br>';
      }
      if ( !empty($result["choice4"]) ) {
        echo '<input type="radio" name="answer" value="d">' . $result["choice4"] . '<br>';
      }
      if ( !empty($result["choice5"]) ) {
        echo '<input type="radio" name="answer" value="e">' . $result["choice5"] . '<br>';
      }
      if ( !empty($result["choice6"]) ) {
        echo '<input type="radio" name="answer" value="f">' . $result["choice6"] . '<br>';
      }
      echo "<br>";
      echo '<input type="submit" value="Submit Answer">';
      echo "</form>";
  
      $_SESSION["questnum"] = $_SESSION["questnum"] + 1;
    } else {
      $sql = "SELECT * FROM shortAnswer WHERE quizNum=" . $_SESSION["quiz"] . " LIMIT " . $_SESSION["questnum"] . ", 1;";
      $prelimResult = $conn->query($sql);
      $result = $prelimResult->fetch_assoc();

      if ($prelimResult->num_rows < 1) {
        $_SESSION["questtype"] = "sa";
        $_SESSION["questnum"] = 0;
        
        header('Location: ./multchoice.php');
        die();
      }

      echo '<p id="question">' . $result["question"] . "</p>";

      echo '<form id="answer" action="./multchoice.php" method="POST">
              ANSWER: <br><textarea name = "answer" cols = "50" rows = "4"></textarea><br>
              <input type="submit" value="Submit Answer">
            </form>';

      $_SESSION["questnum"] = $_SESSION["questnum"] + 1;
    }
  }
#}

echo "</body>";
?>
