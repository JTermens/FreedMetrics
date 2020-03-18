<?php

// Just not loged users can access to the login page
if (isset($_SESSION['username'])) {
  header("Location: index.php?pagename=Home");
}

// Mail variables
require "$mailer_incDir/email_send.php";

$title = "FreedMetrics - Forgot your password?";

print(page_head($_SESSION['pagename'],$title));

if ($_POST){

  $userEmail = $_POST['email'];

  if ($userEmail == ''){
    header('Location: index.php?pagename=ForgotPassword&error=empty');
  }else{
    $query = "SELECT name FROM Persons WHERE email = '$userEmail' ";
    $result = mysqli_query($conn, $query) or die (mysqli_error($conn));

    $count = mysqli_num_rows($result);
    if ($count > 0){
      try{

        $row = mysqli_fetch_row($result);
        $name = $row[0];
        $fpkey = bin2hex(random_bytes(16));
        $recovery_subject = 'Freed Metrics: Password change requested' ;
        $recovery_body = "<p>Dear $name, a request to change your password has been made. Please, follow the link below,
        you will be able to change your password there.<br><br>
        If you haven't performed such request, please ignore this email, as this link will expire after 30 minutes.<p><br><br>
        <a href='localhost/freedmetrics_final/html/FreedMetrics/index.php?pagename=PasswordChange&email=$userEmail&fpkey=$fpkey'>Change your password.<a>
        ";

        $conn->query("UPDATE Persons SET fpkey_expire=DATE_ADD(NOW(), INTERVAL 30 MINUTE), fpkey='$fpkey' WHERE email='".$userEmail."'");

        send_email($mail,$userEmail,$name,$recovery_subject,$recovery_body);
        header("location:index.php?pagename=ForgotPassword&success=sent");

      }catch(Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

    }else{
      header('Location: index.php?pagename=ForgotPassword&error=not_registered');
    }
  }

}
?>

<div class="container">
  <div class="card border-0 shadow my-5 col-lg-8 col-md-10 mx-auto">
    <div class="card-body p-5">
      <form action="" method="post">

        <h2>Have you forgot your password?</h2>

          <div class="form-group">
            <label>An email will be sent to the address provided below. From there you will be able to change your password.</label>
            <input id="forgot_password" type="text" name="email" class="form-control required" placeholder="Write your email...">
          </div>

          <input type="submit" name="request-password" value="Send Request" class="btn btn-primary" style="float:left">
          <p id="not_registered" style="float:right;font-size:15px;color:red;margin:0px;display:<?php if (isset($_GET['error']) && $_GET['error'] == 'not_registered'){echo 'block;';}else{echo 'none;';} ?>">You are not registered!</p>
          <p id="empty_box" style="float:right;font-size:15px;color:red;margin:0px;display:<?php if (isset($_GET['error']) && $_GET['error'] == 'empty'){echo 'block;';}else{echo 'none;';} ?>">You must enter an email!</p>
          <p id="empty_box" style="float:right;font-size:15px;color:green;margin:0px;display:<?php if (isset($_GET['success']) && $_GET['success'] == 'sent'){echo 'block;';}else{echo 'none;';} ?>">Email sent! Please, check your inbox.</p>

      </form>
    </div>
  </div>
</div>

<!-- Scripts for the Forgot Password page -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <!-- IMPORTING JQUERY UI -->
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php print(page_footer($_SESSION['pagename']));
