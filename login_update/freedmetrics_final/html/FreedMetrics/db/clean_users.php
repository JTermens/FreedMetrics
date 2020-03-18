<?php
// Database connection variables
  $servername = "localhost";
  $dbusername = "CommunistDolphin";
  // IMPORTANT, NEXT VARIABLE WILL HAVE TO CONTAIN THE PASSWORD FOR THE DATABASE (IF THERE IS NONE, LEAVE EMPTY)
  $dbpassword = "KillerDolphin";
  $dbname = "freedmetrics";

// Database connection
  $db = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check if connection was successful
  if ($db->connect_error){
    die("Connection failed!: " . $db->connect_error);
  }

  $sql = "DELETE FROM Persons WHERE HOUR(TIMEDIFF(NOW(), register_date))>24 && is_verified = 0";
  if(mysqli_query($db, $sql)){
    echo "Data deleted successfully";
  }else{
    echo "Data was not deleted ". $conn->error;
  }
  $db->close();
?>
