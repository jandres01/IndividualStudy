<?php
  if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
    echo "<p>You must access this page from on campus through dias11.</p></body></html>";
    die ();
  }
  session_start();
?>

<html>
<head>
</head>
<body>

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

  if(isset($_GET['editQuiz'])) {
    $quiz_id= $_GET['editQuiz'];
   
    echo "number = " .$quiz_id;
    unset($_GET['editQuiz']);

    $list_id = array();
    $sql = "SELECT * FROM hasTaken where quiz_id = '". $quiz_id ."';";
    $result = $conn->query($sql);
//  var_dump($result);
    $list_id = array();
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $userID = $row['user_id'];
        array_push($list_id,$userID);
      }
    } else {
    echo "0 users";
    }

 /*   $sql3 = "Select * From users where ;";
    $result3 = $conn->query($sql3);
    if($result3->num_rows > 0) {
      while($row3 = $result3->fetch_assoc()) {
        echo "<tr><td>User ".$row3["id"]."</td>
              <td><button type='submit' value='".$row3['id']."' 
                 class='btn btn-default' name='editQuiz'> Edit Quiz</button>
              </td></tr>";
      }
    } else {
      echo "0 Quizzes";
    } */

    echo "<form action='professorQuizView.php'  method='get'>
         <table><tr><th>User</th><th>Quiz #</th><th>MC Grade</th><th>SA Grade</th>
                    <th>Edit SA</th> </tr>";
    foreach ($list_id as $item) {
      $sql = "Select * From multChoiceScore where uid = '".$item."' 
              AND quizid = '".$quiz_id."';";
      $result = $conn->query($sql);
      if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 

      $sql2 = "Select * From shortAnswerScore where uid = '".$item."' 
              AND quizid = '".$quiz_id."';";
      $result2 = $conn->query($sql2);
      if($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {

      $sql3 = "Select * From users where id = '".$item."';";
      $result3 = $conn->query($sql3);

      if($result3->num_rows > 0) {
        while($row3 = $result3->fetch_assoc()) {
          echo "<tr><td>".$row3["last"].", ".$row3["first"]."</td><td>".$quiz_id."</td>
             <td>".$row["grade"]."</td><td>".$row2["grade"]."</td>
             <td><button type='submit' value='".$item."' 
                 class='btn btn-default' name='editSA'>edit Score</button>
             </td></tr>";
        }
      } else {
        echo "0 from toDoList";
      }
    }
    }}
    }}
    echo "</table></form>";
/*
  //echo " size = ".$size;
      echo "userid =" .$user_id;
      $sql2 = "Select * from users where user_id= '".$user_id ."';";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
      // output data of each row
        while($row = $result->fetch_assoc()) {
          $userID = $row['user_ID'];
          $_SESSION['user_id'] = $userID;
        }
      } else {
      echo "0 users";
      }
*/
  } 

?>
</body>
</html>

