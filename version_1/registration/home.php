<?php

session_start();
if(!isset($_SESSION['username'])){
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_SESSION['username'];?>'s main Page</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css "href="style.css">
  </head>
  <body>
    <div class="container" style="text-align:center; margin-top: 400px">
    <h1>Welcome again, <?php echo $_SESSION['username'];?>.</h1>
    <a href="logout.php">
      <button type="button" name="Logout_btn" class="btn btn-primary">Log Out</button>
    </a>
    </div>
  </body>
</html>
