<?php

session_start();

// Form data from login.php
$email = $_POST['email'];
$password = $_POST['password'];

// Variables to open the database
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

$check = "SELECT * FROM Persons WHERE email='".$email."' && password='".md5($password)."'";
$query = mysqli_query($conn, $check);
if(mysqli_num_rows($query) == 1){
  // If this is true, then the user is at least registered, now check if the account is activated:
  $check = "SELECT * FROM Persons WHERE email='".$email."' && password='".md5($password)."' && is_verified=1";
  $query = mysqli_query($conn, $check);
  if(mysqli_num_rows($query) == 1){
    // User is registered and with an activated account. Let's retrieve the username for the session:
    $check = "SELECT name FROM Persons WHERE email='".$email."'";
    $query = mysqli_query($conn, $check);
    $name = $query->fetch_row();
    $_SESSION['username'] = $name[0];
    $_SESSION['email'] = $email;
    header('location:home.php');
  }else{
    header("location:login.php?error=not_activated");
  }
}else{
  header("location:login.php?error=not_registered");
}

mysqli_close($conn);

?>
