<?php
  function redirect(){
    header('Location: login.php');
    exit();
  }
  if (!isset($_GET['email']) || !isset($_GET['vkey'])) {
    redirect();
  }
  else {
    $servername = "";
    $dbusername = "";
    // IMPORTANT, NEXT VARIABLE WILL HAVE TO CONTAIN THE PASSWORD FOR THE DATABASE (IF THERE IS NONE, LEAVE EMPTY)
    $dbpassword = "";
    $dbname = "freedmetrics_database";

    // Create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $email = $conn->real_escape_string($_GET['email']);
    $vkey = $conn->real_escape_string($_GET['vkey']);

    $check = $conn->query("SELECT name FROM Persons WHERE email='".$email."' AND vkey='".$vkey."' AND is_verified=0");
    if ($check->num_rows > 0) {
      $conn->query("UPDATE Persons SET is_verified=1, vkey='Done' WHERE email='".$email."'");
      redirect();
    }else{
      redirect();
    }
  }

?>
