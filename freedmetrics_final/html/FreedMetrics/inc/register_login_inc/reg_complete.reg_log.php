<?php

  function redirect(){
    header('Location: index.php?pagename=Login');
    exit();
  }

  if (!isset($_GET['email']) || !isset($_GET['vkey'])) {
    redirect();
  }
  else {
    $email = $conn->real_escape_string($_GET['email']);
    $vkey = $conn->real_escape_string($_GET['vkey']);

    $check = $conn->query("SELECT name FROM Persons WHERE email='".$email."' AND vkey='".$vkey."' AND is_verified='0'");
    if ($check->num_rows > 0) {
      $conn->query("UPDATE Persons SET is_verified=1 WHERE email='".$email."'");

      // once a user is verified, update the number of users
      $num_users = $conn->query("SELECT num_users FROM Web_Statistics WHERE idWeb_Statistics='1'");
      $num_users = $num_users->fetch_assoc();
      $num_users = intval($num_users['num_users'])+1;
      $conn->query("UPDATE Web_Statistics SET num_users = '$num_users' WHERE idWeb_Statistics='1'");
      redirect();
    }else{
      redirect();
    }
  }
