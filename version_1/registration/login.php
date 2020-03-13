<!DOCTYPE html>
<?php
// This code will alert only when returning from a successful register. It works as PHP echoes the javascript script
  if (isset($_GET['email_sent'])){
    echo "<script type='text/javascript'>alert('A confirmation email has been sent to the provided address. Please check your inbox. If said mail is not there, please also check your SPAM folder.');</script>";
  }
?>
<html>
  <head>
    <title>Log In / Sign In</title>
    <!-- IMPORTING JQUERY -->
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
    <!-- IMPORTING BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- IMPORTING CUSTOM CSS -->
    <link rel="stylesheet" type="text/css "href="style.css">
    <!-- IMPORTING ICONS -->
    <script src="https://kit.fontawesome.com/45a8aedb40.js" crossorigin="anonymous"></script>

    <style media="screen">
      .tooltip:hover{opacity:1!important;}
    </style>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#reg_name").autocomplete({
          source:'NameSearch.php'
        });
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

    <script type="text/javascript">
      function warnings(){
        // This function toggles the warnings for the form
        var special_characters = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        var email = document.getElementById("reg_email");
        var email_warning = document.getElementById("wrong_email");

        var name = document.getElementById("reg_name");
        var name_warning = document.getElementById("wrong_name");

        var pass = document.getElementById("reg_pass");
        var pass_warning = document.getElementById("wrong_pass");

        var rep_pass = document.getElementById("rep_pass");
        var rep_warning = document.getElementById("wrong_repeat");

        var email_ok = 0;
        var pass_ok = 0;
        var name_ok = 0;
        var rep_ok = 0;


        if (email.value == ""){
          email_warning.style.display = "none";
          e_check.style.display = "none";
        }else{
          if (email.value.includes("@") && email.value.includes(".")){
            email_warning.style.display = "none";
            var email_ok = 1;
            e_check.style.display = "block";
          }else{
            e_check.style.display = "none";
            email_warning.style.display = "block";
          }
        }

        if (pass.value == ""){
          pass_warning.style.display = "none";
          p_check.style.display = "none";
        }else{
          if (pass.value.length >= 8 && /[0-9]/.test(pass.value) == true && special_characters.test(pass.value) == true){
            pass_warning.style.display = "none";
            p_check.style.display = "block";
            var pass_ok = 1;
          }else{
            p_check.style.display = "none";
            pass_warning.style.display = "block";
          }
        }

        if (rep_pass.value == ""){
          rep_warning.style.display = "none";
          rp_check.style.display = "none";
        }else{
          if (rep_pass.value == pass.value){
            rep_warning.style.display = "none";
            rp_check.style.display = "block";
            var rep_ok = 1;
          }else{
            rp_check.style.display = "none";
            rep_warning.style.display = "block";
          }
        }

        if (name.value.length > 0){
          name_warning.style.display = "none";
          n_check.style.display = "block";
          name_ok = 1;
        }else{
          n_check.style.display = "none";
          name_warning.style.display = "block";
        }

        if (email_ok == 1 && name_ok == 1 && pass_ok == 1 && rep_ok == 1){
          document.getElementById("reg_submit").disabled = false;
        }else{
          document.getElementById("reg_submit").disabled = true;
        }
      }
    </script>

  </head>
  <body>
    <div class="container">
      <div class="login-box">
      <div class="row">
        <div class="col-md-6 login">
          <h2>Log In</h2>
          <form action="validation.php" method="post" style="margin:0;position:absolute;top: 50%;-ms-transform: translateY(-50%);transform: translateY(-50%);">

            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control required">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control required">
            </div>

            <button type="submit" name="submit_button" class="btn btn-primary">Log In</button>
            <p id="not_registered" style="float:right;font-size:15px;color:red;margin-left:5px;margin-top:10px;display:<?php if (isset($_GET['error']) && $_GET['error'] == 'not_registered'){echo 'block;';}else{echo 'none;';} ?>">You are not registered!</p>
            <p id="not_activated" style="float:right;font-size:15px;color:red;margin-left:5px;margin-top:10px;display:<?php if (isset($_GET['error']) && $_GET['error'] == 'not_activated'){echo 'block;';}else{echo 'none;';} ?>">Your account is not activated!</p>
          </form>
        </div>
        <div class="col-md-6 register">
          <h2>Register</h2>
          <form action="registration.php" method="post">

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
  </body>
</html>
