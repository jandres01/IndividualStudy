<?php
  $servername = "localhost";
  $user = "quizproject";
  $pass = "QuizGradesDontMatter";
  $dbname = "quizproject";
  // Create connection
  $conn = new mysqli($servername, $user, $pass, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "failed connection";
  }
 
  echo "<form action='editQuiz.php'  method='post'>
         <table><tr><th>Quizzes</th><th>Edit Quiz</th></tr>";
    $sql3 = "Select * From quizzes;";
    $result3 = $conn->query($sql3);
    if($result3->num_rows > 0) {
      while($row3 = $result3->fetch_assoc()) {
        echo "<tr><td>Quiz ".$row3["id"]."</td>
              <td><button type='submit' value='".$row3['id']."' 
                 class='btn btn-default' name='editQuiz'> Edit Quiz</button>
              </td></tr>";
      }
    } else {
      echo "0 Quizzes";
    }
  echo "</table></form>";

?>
