<?php

if(!isset($_GET['fpkey'])){
  header('Location: index.php?pagename=Home');
}

// Just not loged users can access to the login page
if (isset($_SESSION['username'])) {
  header("Location: index.php?pagename=Home");
}

$title = "FreedMetrics - Change your password";

// This allows only the user who clicked on the link to access this page
$fpkey = $_GET['fpkey'];
$query = "SELECT * FROM Persons WHERE fpkey='$fpkey'";
$result = mysqli_query($conn, $query) or die (mysqli_error($conn));

if (mysqli_num_rows($result) == 0){
  header("Location: index.php?pagename=Home");
}

// This forbids the access to the page if fpkey is expired
$query = "SELECT * FROM Persons WHERE fpkey='$fpkey' && MINUTE(TIMEDIFF(NOW(), fpkey_expire))>=30";
$result = mysqli_query($conn, $query) or die (mysqli_error($conn));

if (mysqli_num_rows($result) > 0){
  header("Location: index.php?pagename=Home");
}

if ($_POST){
  // Encrypt password
  $new_password = md5($_POST['password']);
  $query= "UPDATE Persons SET password='$new_password', fpkey=NULL WHERE fpkey='$fpkey'";
  $result = mysqli_query($conn, $query) or die (mysqli_error($conn));
  header("Location: index.php?pagename=Login");
}

print(page_head($_SESSION['pagename'],$title));

?>

<div class="container">
  <div class="card border-0 shadow my-5 col-lg-8 col-md-10 mx-auto">
    <div class="card-body p-5">
      <form action="" method="post">

        <h2>Change your password</h2>

        <div class="form-group">
          <label>Password</label>
          <p id="wrong_pass" style="float:right;font-size:12px;color:red;margin:2px;">Password has to be at least 8 characters and contain a
          <a href="#" data-toggle="tooltip" title=' ` ! @ # $ % ^ &amp; * ( ) _ + - = [ ] { } ; &apos; : &quot; | , . &lt;&gt; / \ ? ~ ' data-placement="bottom" style="color:red;text-decoration:underline;text-decoration-color:red;">special character</a>
                and a number</p>
          <i class="fas fa-check" style="float:right;color:limegreen;" id="p_check"></i>
          <input type="password" name="password" class="form-control required" id="reg_pass" maxlength="20" onkeyup="change_password_warnings()" onclick="change_password_warnings()">
        </div>

        <div class="form-group">
          <label>Repeat Password</label>
          <p id="wrong_repeat" style="float:right;font-size:12px;color:red;margin:0px;">Passwords do not match</p>
          <i class="fas fa-check" style="float:right;color:limegreen;" id="rp_check"></i>
          <input type="password" name="password" class="form-control required" id="rep_pass" maxlength="20" onkeyup="change_password_warnings()" onclick="change_password_warnings()">
        </div>

          <input id="change_password" type="submit" name="change_password" value="Confirm changes" class="btn btn-primary" style="float:left">

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
    <script type="text/javascript">
    // This script hides by default every warning in the form when the page is loaded
      $(document).ready(function(){
        var pass_warning = document.getElementById("wrong_pass");
        var rp_warning = document.getElementById("wrong_repeat");

        var p_check = document.getElementById("p_check");
        var rp_check = document.getElementById("rp_check");

        pass_warning.style.display = "none";
        rp_warning.style.display = "none";

        p_check.style.display = "none";
        rp_check.style.display = "none";

        document.getElementById("change_password").disabled = true;
      });
    </script>
    <script type="text/javascript">
      function change_password_warnings(){
        // This function toggles the warnings for the form
        var special_characters = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

        var pass = document.getElementById("reg_pass");
        var pass_warning = document.getElementById("wrong_pass");

        var rep_pass = document.getElementById("rep_pass");
        var rep_warning = document.getElementById("wrong_repeat");

        var pass_ok = 0;
        var rep_ok = 0;

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

        if (pass_ok == 1 && rep_ok == 1){
          document.getElementById("change_password").disabled = false;
        }else{
          document.getElementById("change_password").disabled = true;
        }
      }
    </script>

<?php print(page_footer($_SESSION['pagename']));