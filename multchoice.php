<?php
session_start();

if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
  header('Location: ./Task_5_part1.php?error=server');
}

$servername = "localhost";
$username = "quizproject";
$password = "QuizGradesDontMatter";
$dbname = "quizproject";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION["quiz"] && isset($_SESSION["questtype"]) && isset($_SESSION["questnum"])) {
  echo "The necessary Session variables aren't set for you to be able to use this page, why are you here?";
  die();
}

if ($_SESSION["questtype"] == "mc") {
  $sql = "SELECT * FROM multChoice WHERE quizNum=" . $_SESSION["quiz"] . " LIMIT " . $_SESSION["questnum"] . ", 1;";
  $result = $conn->query($sql)->fetch_assoc();
  echo $result["question"];
  if (!is_null($result["choice1"])) { echo $result["choice1"] };
  if (!is_null($result["choice2"])) { echo $result["choice2"] };
  if (!is_null($result["choice3"])) { echo $result["choice3"] };
  if (!is_null($result["choice4"])) { echo $result["choice4"] };
  if (!is_null($result["choice5"])) { echo $result["choice5"] };
  if (!is_null($result["choice6"])) { echo $result["choice6"] };
} else {
  $sql = "SELECT * FROM shortAnswer WHERE quizNum=" . $_SESSION["quiz"] . " LIMIT " . $_SESSION["questnum"] . ", 1;";
  
}



$sql = "SELECT * FROM tasks WHERE Username='" . $_SESSION["username"] . "' ORDER BY Date";
$result = $conn->query($sql);
echo "Date, Task<br>";
while($row = $result->fetch_assoc()) {
  echo $row["Date"] . ": " . $row["Task"] . ' <a href="./Task_5_part3.php?del=true&id=' . $row["ID"] . '">Delete</a><br>';
}
?>
