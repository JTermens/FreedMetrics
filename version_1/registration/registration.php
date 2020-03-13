<?php
// necessary for the mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

session_start();

$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];

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

// Generate verification key (NOT IMPLEMENTED YET)
$vkey = md5(time().$name);

// Encrypt password
$password = md5($password);

$check = "SELECT * FROM Persons WHERE email='".$email."'";
$query = mysqli_query($conn, $check);
if(mysqli_num_rows($query)>0){
  header("location:login.php?error=already_registered");
}else{
  $sql = "INSERT INTO Persons (email, name, password, vkey)
  VALUES ('$email', '$name', '$password', '$vkey')";
  if (mysqli_query($conn, $sql)) {

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output (0 deactivates it)
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'freedmetrics@gmail.com';               // SMTP username
        $mail->Password   = 'KillerDolphin';                        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('freedmetrics@gmail.com', 'Freed Metrics');
        $mail->addAddress($email, $name);                           // Add a recipient
        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Freed Metrics: Please, verify your email and complete your registration.';
        $mail->Body    = "<p>Welcome, $name, to Freed Metrics! Please, click on the link below in order to confirm your email and become
        one of our proud users! Again, thank you for using our service.<p> <br>
        <a href='localhost/project/registration/reg_complete.php?email=$email&vkey=$vkey'>Confirm your email and activate your account!<a>";
        $mail->send();
        header("location:login.php?email_sent=true");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);

?>
