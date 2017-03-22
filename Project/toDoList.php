<?php
  if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
    echo "<p>You must access this page from on campus through dias11.</p></body></html>";
    die ();
  }
  session_start();
 //So SESSION doesn't remove vars when page is closed...
  if (is_null($_SESSION['userName']) || is_null($_SESSION['password'])) {
    $_SESSION['userName'] = trim($_POST['username']);
    $_SESSION['password'] = $_POST['password'];
  } 
    if ($_SESSION['userName'] == "jandres" && $_SESSION['password'] == "Trinity") {
    //    echo "right user = ".$_SESSION['userName'];	   
    //    echo "right pass = ".$_SESSION['password'];
      //session_start();
    } else if ($_SESSION['userName'] == "mlewis" && $_SESSION['password'] == "perfectScore") {
   //     echo "right user = ".$_SESSION['userName'];
   //     echo "right pass = ".$_SESSION['password'];
//	echo "WTF";
      //session_start();
    } else {
        echo 'Wrong username or password';    
        echo "right user = ".$_SESSION['userName'];
        echo "right pass = ".$_SESSION['password'];
        header('Refresh:0 ; URL = logout.php');
    //    exit();
    }
  
?>

<html>
<head>
</head>
<body>

<div class = "container">
  <form class = "adding" method = "post">
    <table>
      <tr>
        <td>Enter Task</td>
        <td><input type="text" placeholder="Task= Buy Grocery" name="task_input" id="task_input"></td>
      </tr>
      <tr>
        <td>Enter Date</td>        <td><input type="text" placeholder="YYYY-MM-DD" name="date_input" id="date_input"></td>
      </tr>
      <tr>
        <td><input type="button" name="button1" value="Add Tasks" onclick="addTask();" ></td>
      </tr>
    </table>
  </form>
</div>  
<!--
<div class = "container">
  <form class = "adding" role = "form" 
     action = "Adding.php" method = "post">
    <input name="task" placeholder="Task= Buy Grocery" />
    <input name="deadline" placeholder="YYYY-MM-DD" />
    <button id="add_task" type="submit" name="add_task">Add Task</button>
  </form>
</div>

<p id="test"></p> -->
<script>

  function addTask() {
    
        
    //$task_input = document.getElementById("task_input").value;
    //$deadline_input = document.getElementById("date_input").value;

    <?php

    $task_input = document.getElementById("task_input").value;
    $deadline_input = document.getElementById("date_input").value;
    $servername = "localhost";
    $user = "jandres";
    $pass = "0791061";
    $dbname = "jandres";
    // Create connection
    $conn = new mysqli($servername, $user, $pass, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      echo "failed connection";
    }
 
    $sql = "INSERT INTO toDoList (Tasks,Deadline) 
          VALUES ('".$task_input ."', '" .$deadline_input. "');";
  //echo $sql;   //print query
    $result = $conn->query($sql);

    echo $_SESSION['user_id'];

    $sql2 = "Select * From toDoList where Tasks = '".$task_input."' 
           && Deadline = '".$deadline_input."';";
    $result2 = $conn->query($sql2);
    // echo $sql2;
    if($result2->num_rows > 0) {
      while($row2 = $result2->fetch_assoc()) {
        $task_ID = $row2['task_ID'];
        echo 'task_ID = ' .$taskID;
      }
    }

    $sql3 = "INSERT INTO user_list (toDoList_id, user_id) 
           VALUES ('".$task_ID."','".$_SESSION['user_id']."');";
    $result3 = $conn->query($sql3);

    echo 'You have added a task to your To Do List!';
    ?>
  }

</script>  

<?php
//  echo trim($_POST['username']);
//  echo $_POST['password'];
  $servername = "localhost";
  $user = "jandres";
  $pass = "0791061";
  $dbname = "jandres";
  // Create connection
  $conn = new mysqli($servername, $user, $pass, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "failed connection";
  } 
  
  $sql = "SELECT * FROM users where UserName = '". $_SESSION['userName'] ."' && Password = '".$_SESSION['password']."';";
//  echo $sql;   //print query
  $result = $conn->query($sql);
//  var_dump($result);
  if ($result->num_rows > 0) { 
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $userID = $row['user_ID'];
      $_SESSION['user_id'] = $userID;
    }
  } else {
    echo "0 users";
  }
  $sql2 = "Select * From user_list where user_id = '".$userID."';";
  $result2 = $conn->query($sql2);
  
  $list_id = array();
  if($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
      $taskID = $row2['toDoList_id'];
     // echo 'task_ID = ' .$taskID;
      array_push($list_id,$taskID);
//      echo "user ID " . $userID;
    }
  } else {
    echo "0 from user_list";
  }

   echo "<form action='removing.php'  method='get'>
         <table><tr><th>Task</th><th>DeadLine</th><th>Remove Task</th></tr>";
  foreach ($list_id as $item) {
    $sql3 = "Select * From toDoList where task_ID = '".$item."';";
    $result3 = $conn->query($sql3);

    if($result3->num_rows > 0) {
      while($row3 = $result3->fetch_assoc()) {
        echo "<tr><td>".$row3["Tasks"]."</td><td>".$row3["Deadline"]."</td>
             <td><button type='submit' value='".$row3['task_ID']."' 
                 class='btn btn-default' name='delete'> Delete task</button>
       </td></tr>";
      }
    } else {      
      echo "0 from toDoList";
    }
  }
  echo "</table></form>";

  if($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
      $taskID = $row2['toDoList_id'];
      array_push($list_id,$taskID);
    }
  } else {
    echo "0 end";
  }  
  mysqli_close($conn);
?>

Click to <a href = "logout.php" tite = "Logout"> Logout</a>Session.
</body>
</html>
