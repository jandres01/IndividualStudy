<?php
  session_start();
  if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
    echo "<p>You must access this page from on campus through dias11.</p></body></html>";
    die ();
  }

 //So SESSION doesn't remove vars when page is closed...
  if (is_null($_SESSION['userName']) || is_null($_SESSION['password'])) {
    $_SESSION['userName'] = trim($_POST['username']);
    $_SESSION['password'] = $_POST['password'];
  } 

  if ($_SESSION['userName'] == "dbomer"
      && $_SESSION['password'] == "trinity1") {
//      echo "right user = ".$_SESSION['userName'];      
//      echo "right user = ".$_SESSION['password'];
  } else if ($_SESSION['userName'] == "mlewis" && 
             $_SESSION['password'] == "trinity2") {
 //     echo "right user = ".$_SESSION['userName'];
  } else { 
      echo 'Wrong username or password';    
      echo "right user = ".$_SESSION['userName'];
      echo "right pass = ".$_SESSION['password'];
      header('Refresh:0 ; URL = logout.php');
    //  exit();
  }

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

  $sql = "SELECT * FROM users where user = '". $_SESSION['userName'] ."' && pass = '".$_SESSION['password']."';";
  //  echo $sql;   //print query
  $result = $conn->query($sql);
  //  var_dump($result);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $userRole = $row['isStudent'];
      $student_id = $row['id'];
      $_SESSION['isStudent'] = $userRole;
      $_SESSION['student_id'] = $student_id;
    }
  } else {
    echo "0 users";
  }

?>

<!DOCTYPE html>
<html lang=?~@~]en?~@~]>
  <head>
    <meta charset=?~@~]utf-8?~@~]>
    <title>This is a title</title>
<!--    <script src="table.js"></script> -->
    <style type="text/css">
      @import url('homeDesign.css'); /* locality matters */
      h1 { color:red;} /* dont like this better in other file */
    </style>
  </head>
  <body>
   <h1 class="damn">Project 1: Dan, Berni & Robbie!!! </h1>
   <nav>
     <ul>
       <li><a href="mainPage.html">Home</a></li> 
       <?php
         if($_SESSION['isStudent'] == 'F') { ?> 
       <li><a href= "gradeQuizzes.php">Grade Quizzes</a></li>
       <li><a href="">Analyze Results</a></li>
      <?php } ?> 
     </ul>
   </nav>
   <main>
    <section>
     <h5> Announcement 2</h5>
     <article>
       <?php
       if($_SESSION['isStudent'] == 'T') { ?>
         Group met-up and accomplished a quarter of the project today <br/>
         Hopefully we can finish this in time.
       <?php } else { ?>
         Reminder to give everyone +100 for doing such a great job with the Projects!
       <?php } ?>
     </article>
    </section>
    <section>
      <h5> Announcement 1 </h5>
      <article> Dan, Bernie & Robbie have decided to get Pizza together and possibly have a beer together before working on the project :D </article>
    </section>
   </main>

   <aside>
     <?php
       if($_SESSION['isStudent'] == 'T') { ?>
       <h2> Take a Quiz  </h2>
       
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
           echo "<form action='quizView.php'  method='post'>
                 <table><tr><th>Quizzes</th><th>Take Quiz</th></tr>";
           $sql3 = "Select * From quizzes;";
           $result3 = $conn->query($sql3);
           if($result3->num_rows > 0) {
             while($row3 = $result3->fetch_assoc()) { 
              echo "<tr><td>Quiz ".$row3["id"]."</td>
                    <td><button type='submit' value='".$row3['id']."' 
                    class='btn btn-default' name='quizID'> Take Quiz</button>
                    </td></tr>";
             }
           } else {
             echo "0 Quizzes";
           }
           echo "</table></form>";
           
         } else { ?>
       <h2> Will I ever have Time to Grade Quizzes?  </h2>
       <p> Stay Tuned for updated news :)  </p>
     <?php } ?>
   </aside>

   <footer>
   <p>Click to <a href = "logout.php" tite = "Logout"> Logout</a> Session.</p>
   </footer>

  </body>
</html>

