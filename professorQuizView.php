<style>
#correct {
  color: #00cc00;
}

#incorrect {
  color: red;
}
</style>

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

$sql = "select *, multChoice.ans AS realAns from multChoice, multChoiceAnswer WHERE multChoiceAnswer.quest_id = multChoice.id && multChoice.quizNum = 1 && multChoiceAnswer.user_id = 3;"; 
$prelimResult = $conn->query($sql);

if ($prelimResult->num_rows > 0) {
  while($result = $prelimResult->fetch_assoc()) {
    echo '<p>';
    print_r($result);
    echo '</p>';

    echo '<p id="question">' . $result["question"] . "</p>";
    echo '<form id="answer" method="post" action="./multchoice.php">';
    if ( !empty($result["choice1"]) ) {
      echo '<input type="radio" name="answer" value="a"';
      if ($result["ans"] == "a") {
        echo ' checked';
      }
      echo ' disabled>';

      echo '<p style="display:inline"';
      if ($result["realAns"] == "a") {
        echo ' id="correct"';
      } else if ($result["ans"] == "a"){
        echo ' id="incorrect"';
      }
      echo ">" . $result["choice1"] . '</p><br>';
    }
    if ( !empty($result["choice2"]) ) {
      echo '<input type="radio" name="answer" value="b"';
      if ($result["ans"] == "b") {
        echo ' checked';
      }
      echo ' disabled>';

      echo '<p style="display:inline"';
      if ($result["realAns"] == "b") {
        echo ' id="correct"';
      } else if ($result["ans"] == "b"){
        echo ' id="incorrect"';
      }
      echo ">" . $result["choice2"] . '</p><br>';
    }
    if ( !empty($result["choice3"]) ) {
      echo '<input type="radio" name="answer" value="c"';
      if ($result["ans"] == "c") {
        echo ' checked';
      }
      echo ' disabled>';

      echo '<p style="display:inline"';
      if ($result["realAns"] == "c") {
        echo ' id="correct"';
      } else if ($result["ans"] == "c"){
        echo ' id="incorrect"';
      }
      echo ">" . $result["choice3"] . '</p><br>';
    }
    if ( !empty($result["choice4"]) ) {
      echo '<input type="radio" name="answer" value="d"';
      if ($result["ans"] == "d") {
        echo ' checked';
      }
      echo ' disabled>';

      echo '<p style="display:inline"';
      if ($result["realAns"] == "d") {
        echo ' id="correct"';
      } else if ($result["ans"] == "d"){
        echo ' id="incorrect"';
      }
      echo ">" . $result["choice4"] . '</p><br>';
    }
    if ( !empty($result["choice5"]) ) {
      echo '<input type="radio" name="answer" value="e"';
      if ($result["ans"] == "e") {
        echo ' checked';
      }
      echo ' disabled>';

      echo '<p style="display:inline"';
      if ($result["realAns"] == "e") {
        echo ' id="correct"';
      } else if ($result["ans"] == "e"){
        echo ' id="incorrect"';
      }
      echo ">" . $result["choice5"] . '</p><br>';
    }
    if ( !empty($result["choice6"]) ) {
      echo '<input type="radio" name="answer" value="f"';
      if ($result["ans"] == "f") {
        echo ' checked';
      }
      echo ' disabled>';

      echo '<p style="display:inline"';
      if ($result["realAns"] == "f") {
        echo ' id="correct"';
      } else if ($result["ans"] == "f"){
        echo ' id="incorrect"';
      }
      echo ">" . $result["choice6"] . '</p><br>';
    }
    echo "</form>";
  }
}

$sql = "select *, shortAnswer.ans AS realAns from shortAnswer, shortAnsAnswer WHERE shortAnsAnswer.quest_id = shortAnswer.id && shortAnswer.quizNum = 1 && shortAnsAnswer.user_id = 3;"; 
$prelimResult = $conn->query($sql);

if ($prelimResult->num_rows > 0) {
  while($result = $prelimResult->fetch_assoc()) {
    print_r($result);
    echo "<br>";
  }
}
?>
