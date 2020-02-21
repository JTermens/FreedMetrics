<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
    <title>Welcome to FreedMetrics!</title>
    <meta charset="utf-8">
    <title><?php echo $_SESSION['username'];?>'s main Page</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css "href="registration/style.css">
  </head>

  <body>
    <div class="container">
      <div class="login-box">
      <div class="row">
        <div class="col-md-12 login">
          <h2 style="text-align:center">FreedMetrics</h2>
  <form name="MainForm" action="search.php" method="GET">
    	<div class="row">
       		<div class="form-group">
          		<label style="text-align:center"><b>Search article by title</b></label>
            		
           		<input type="text" name="user_query" value="Enter the article's title" size="60"/>
              <input type="submit" value="Submit">
      		</div>
    	</div>
		<form>

 		<a href="registration/login.php">
      		<button type="button" name="Login_btn" class="btn btn-primary" style="text-align:center;">Log in</button>
		</a>  

        </div>
      </div>
      </div>
    </div>
  </body>




</html>


