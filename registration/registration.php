<?php

session_start();
//header('location:login.php');

$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];

$servername = "localhost";
$dbusername = "root";
// IMPORTANT, NEXT VARIABLE WILL HAVE TO CONTAIN THE PASSWORD FOR THE DATABASE (IF THERE IS NONE, LEAVE EMPTY)
$dbpassword = "";
$dbname = "freedmetrics";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Generate verification key (NOT IMPLEMENTED YET)
$vkey = md5(time().$name);

// Encrypt password
$password = md5($password);

$check = "SELECT * FROM Persons WHERE email='".$email."'";
$query = mysqli_query($conn, $check);
if(mysqli_num_rows($query)>0){
  echo "This email is alreeady registered";
}else{
  $sql = "INSERT INTO Persons (email, name, password)
  VALUES ('$email', '$name', '$password')";
  if (mysqli_query($conn, $sql)) {
      /* THIS IS A TRY FOR EMAIL CONFIRMATION, DOESN'T WORK YET
      // Send confirmation email
      $to = $email;
      $subject = "Freed Metrics account confirmation"
      $msg = "<a href='http://localhost/project/registration/verify.php?vkey=$vkey'>Register Account</a>";
      $headers = "From freedmetrics@gmail.com \r\n";
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers = "Content-type:text/html;charset=UTF-8"."\r\n";

      mail($to,$subject,$message,$headers);

      header('location:reg_complete.php');
      */
      echo "Registration successful!";
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);

?>
