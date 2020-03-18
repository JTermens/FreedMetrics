<?php

// Form data from login.php
$email = $_POST['email'];
$password = $_POST['password'];

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

    $check = "SELECT person_id FROM Persons WHERE email='".$email."'";
    $query = mysqli_query($conn, $check);
    $person_id = $query->fetch_row();

    $_SESSION['username'] = $name[0];
    $_SESSION['person_id'] = $person_id[0];
    $_SESSION['email'] = $email;

    // update last connection
    $conn->query("UPDATE Persons SET last_connection = NOW() WHERE email='$email'");
    header('location:index.php?pagename=User-Page');
  }else{
    header("location:index.php?pagename=Login&error=not_activated");
  }
}else{
  header("location:index.php?pagename=Login&error=not_registered");
}