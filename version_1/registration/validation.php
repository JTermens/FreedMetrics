<?php

session_start();

// Form data from login.php
$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];

// Variables to open the database
$servername = "localhost";
$dbusername = "TestUser";
// IMPORTANT, NEXT VARIABLE WILL HAVE TO CONTAIN THE PASSWORD FOR THE DATABASE (IF THERE IS NONE, LEAVE EMPTY)
$dbpassword = "123456789_AbC";
$dbname = "freedmetrics";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$check = "SELECT * FROM Persons WHERE email='".$email."' && password='".md5($password)."'";
$query = mysqli_query($conn, $check);
if(mysqli_num_rows($query) == 1){
  $_SESSION['username'] = $name;
  header('location:home.php');
}else{
  header('location:login.php');
}

mysqli_close($conn);

?>
