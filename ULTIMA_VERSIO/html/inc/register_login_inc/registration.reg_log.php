<?php
include_once("$mailer_incDir/email_send.php");

$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];

// Generate verification key
$vkey = md5(time().$name);

// Encrypt password
$password = md5($password);

// today's date

$check = "SELECT * FROM Persons WHERE email='".$email."'";
$query = mysqli_query($conn, $check);
if(mysqli_num_rows($query)>0){
  header("location:index.php?pagename=Login&error=already_registered");
}else{
  $sql = "INSERT INTO Persons (email, name, password, register_date, vkey, is_verified, num_articles_searched, last_connection)
  VALUES ('$email', '$name', '$password', NOW(), '$vkey', '0', '0', NOW())";
  if (mysqli_query($conn, $sql)) {

    try {

        $mail_subject = 'Freed Metrics: Please, verify your email and complete your registration.';
        $mail_body = "<p>Welcome, $name, to Freed Metrics! Please, click on the link below in order to confirm your email and become
        one of our proud users! Again, thank you for using our service.<p> <br>
        <a href='localhost/freedmetrics_final/html/FreedMetrics/index.php?pagename=Reg-complete&email=$email&vkey=$vkey'>Confirm your email and activate your account!<a>";

        send_email($mail,$email,$name,$mail_subject,$mail_body);

        header("location:index.php?pagename=Login&email_sent=true");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);