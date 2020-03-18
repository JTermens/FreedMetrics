<?php

// Just not loged users can access to the login page
if (isset($_SESSION['username'])) {
  header("Location: index.php?pagename=Home");
}

// This code will alert only when returning from a successful register. It works as PHP echoes the javascript script
  if (isset($_GET['email_sent'])){
    echo "<script type='text/javascript'>alert('A confirmation email has been sent to the provided address. Please check your inbox. If said mail is not there, please also check your SPAM folder.');</script>";
  }

$title = "FreedMetrics - Login & Register";

print(page_head($_SESSION['pagename'],$title));
?>
<div class="container">
  <div class="card border-0 shadow my-5 col-lg-8 col-md-10 mx-auto">
    <div class="card-body p-5">
      <div class="row">
        <div class="col-lg-6" style="border-right: 1px solid; border-width: 0.2rem; border-color: var(--color3);">
          <h2>Login</h2>
          <form action="index.php?pagename=Validation" method="post">

            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control required">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control required">
            </div>

            <button type="submit" name="submit_button" class="btn btn-primary" style="float:left;">Log In</button>

            <a href="index.php?pagename=ForgotPassword" style="float:right;">Forgot your password?</a>
            <br><br>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'not_registered'){echo "<p id='not_registered' style='float:left;font-size:15px;color:red;margin-left:5px;margin-top:10px;display:block;'>You are not registered!</p>";} ?>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'not_activated'){echo "<p id='not_activated' style='float:left;font-size:15px;color:red;margin-left:5px;margin-top:10px;display:block;'>Your account is not activated!</p>";} ?>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'wrong_password'){echo "<p id='wrong_password' style='float:left;font-size:15px;color:red;margin-left:5px;margin-top:10px;display:block;'>Wrong password!</p>";} ?>

          </form>
        </div>
        <div class="col-lg-6">
          <h2>Register</h2>
          <form action="index.php?pagename=Registration" method="post">

            <div class="form-group">
              <label>Email</label>
              <p id="already_registered" style="float:right;font-size:15px;color:red;margin:0px;display:<?php if (isset($_GET['error']) && $_GET['error'] == 'already_registered'){echo 'block;';}else{echo 'none;';} ?>">This email is already registered!</p>
              <p id="wrong_email" style="float:right;font-size:15px;color:red;margin:0px;">Please, enter a valid email</p>
              <i class="fas fa-check" style="float:right;color:limegreen;" id="e_check"></i>
              <input type="text" name="email" class="form-control required" id="reg_email" onkeyup="warnings()" onclick="warnings()" placeholder="example@domain.com">
            </div>

            <div class="form-group">
              <label>Name</label>
              <p id="wrong_name" style="float:right;font-size:15px;color:red;margin:0px;">Please, enter your full name</p>
              <i class="fas fa-check" style="float:right;color:limegreen;" id="n_check"></i>
              <input type="text" name="name" class="form-control required" id="reg_name" onkeyup="warnings();" onclick="warnings()" placeholder="Write your full name!">
            </div>

            <div class="form-group">
              <label>Password</label>
              <p id="wrong_pass" style="float:right;font-size:12px;color:red;margin:2px;">Password has to be at least 8 characters and contain a
              <a href="#" data-toggle="tooltip" title=' ` ! @ # $ % ^ &amp; * ( ) _ + - = [ ] { } ; &apos; : &quot; | , . &lt;&gt; / \ ? ~ ' data-placement="bottom" style="color:red;text-decoration:underline;text-decoration-color:red;">special character</a>
                    and a number</p>
              <i class="fas fa-check" style="float:right;color:limegreen;" id="p_check"></i>
              <input type="password" name="password" class="form-control required" id="reg_pass" maxlength="20" onkeyup="warnings()" onclick="warnings()">
            </div>

            <div class="form-group">
              <label>Repeat Password</label>
              <p id="wrong_repeat" style="float:right;font-size:12px;color:red;margin:0px;">Passwords do not match</p>
              <i class="fas fa-check" style="float:right;color:limegreen;" id="rp_check"></i>
              <input type="password" name="password" class="form-control required" id="rep_pass" maxlength="20" onkeyup="warnings()" onclick="warnings()">
            </div>

            <button type="submit" name="submit_button" class="btn btn-primary" id="reg_submit">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Scripts for the login page -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <!-- IMPORTING JQUERY UI -->
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
      // Resolve name collision between jQuery UI and Twitter Bootstrap (they conflict as they use the same name 'tooltip')
      $.widget.bridge('uitooltip', $.ui.tooltip);
    </script>
    <!-- IMPORTING ICONS -->
    <script src="https://kit.fontawesome.com/45a8aedb40.js" crossorigin="anonymous"></script>

    <script type="text/javascript">
      $("#reg_name").autocomplete({
        source: 'inc/register_login_inc/NameSearch.reg_log.php'
      });
    </script>

    <script type="text/javascript">
    // This script hides by default every warning in the form when the page is loaded
      $(document).ready(function(){
        var email_warning = document.getElementById("wrong_email");
        var pass_warning = document.getElementById("wrong_pass");
        var name_warning = document.getElementById("wrong_name");
        var rp_warning = document.getElementById("wrong_repeat");

        var e_check = document.getElementById("e_check");
        var n_check = document.getElementById("n_check");
        var p_check = document.getElementById("p_check");
        var rp_check = document.getElementById("rp_check");

        email_warning.style.display = "none";
        pass_warning.style.display = "none";
        name_warning.style.display = "none";
        rp_warning.style.display = "none";

        e_check.style.display = "none";
        n_check.style.display = "none";
        p_check.style.display = "none";
        rp_check.style.display = "none";

        document.getElementById("reg_submit").disabled = true;
      });
    </script>

    <script>
    // Script for the tooltip containing the info for the special characters in the password field
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>

<?php print(page_footer($_SESSION['pagename']));
