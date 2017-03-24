<style>
#correct {
  color: #00cc00;
}

#incorrect {
  color: red;
}

table {
  table-layout: fixed;
  width: 80%;
}

td {
  word-wrap: break-word;
}

#gradeInput {
  display: inline;
  width: 30px;
}
</style>

<?php
session_start();

if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
  echo "get on dias11";
  die();
}

print_r($_SESSION);

$servername = "localhost";
$username = "quizproject";
$password = "QuizGradesDontMatter";
$dbname = "quizproject";

#echo "wtf";

$_SESSION['studentid'] = $_GET["editSA"];
#$_SESSION['quiz'] = $_GET["quizID"];

#echo $_SESSION['editQuiz'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if( isset($_SESSION['studentid']) && isset($_SESSION['quiz'])) {
  echo '<body>'; 
  
  $sql = "select *, multChoice.ans AS realAns from multChoice, multChoiceAnswer WHERE multChoiceAnswer.quest_id = multChoice.id && multChoice.quizNum=" . $_SESSION['quiz'] . " && multChoiceAnswer.user_id=" . $_SESSION['studentid'] . " ORDER BY multChoice.id;"; 
print $sql;
  $prelimResult = $conn->query($sql);
  
  if ($prelimResult->num_rows > 0) {
    while($result = $prelimResult->fetch_assoc()) {
      echo '<p id="question">' . $result["question"] . "</p>";
      echo '<form>';
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
      echo "<hr>";
    }
  }
  
  $sql = "select *, shortAnswer.ans AS realAns, shortAnswer.id AS questid from shortAnswer, shortAnsAnswer WHERE shortAnsAnswer.quest_id = shortAnswer.id && shortAnswer.quizNum=" . $_SESSION['quiz'] . " && shortAnsAnswer.user_id=" . $_SESSION['studentid'] . " ORDER BY shortAnswer.id;"; 
  $prelimResult = $conn->query($sql);
  
  if ($prelimResult->num_rows > 0) {
    echo '<form id="grading" method="post" action="./shortAnswerGrade.php">';
  
    while($result = $prelimResult->fetch_assoc()) {
      echo '<p id="question">' . $result["question"] . "</p>";
      echo '<table id="shortAns">';
  
      echo "<tr>";
      echo '<th width="45%" id="correct">Sample Correct Answer</th>';
      echo '<th width="45%">Student Answer</th>';
      echo '<th width="10%">Grade</th>';
      echo "</tr>";
  
      echo "<tr>";
      echo '<td>' . $result["realAns"] . "</td>";
      echo '<td style="border-left: 1px solid #bbb">' . $result["ans"] . "</td>";
      echo '<td style="text-align:center;"><input id="gradeInput" type="text" name=' . $result["questid"] . '>/20<br>';
      echo "</tr>";
  
      echo "</table>";
      echo "<hr>";
    }
  
    echo '<input type="submit" value="Submit Results">';
    echo "</form>";
  }
  
  echo '</body>';
}
?>
