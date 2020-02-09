<!DOCTYPE html>
<html>
  <head>
    <title>Log In / Sign In</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css "href="style.css">
  </head>
  <body>
    <div class="container">
      <div class="login-box">
      <div class="row">
        <div class="col-md-6 login">
          <h2>Log In</h2>
          <form action="validation.php" method="post">
            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control required">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control required">
            </div>
            <button type="submit" name="submit_button" class="btn btn-primary">Log In</button>
          </form>
        </div>
        <div class="col-md-6 register">
          <h2>Register</h2>
          <form action="registration.php" method="post">
            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control required">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control required">
            </div>
            <button type="submit" name="submit_button" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
      </div>
    </div>
  </body>
</html>
