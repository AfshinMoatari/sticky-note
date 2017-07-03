<?php
include("inc/connection.php");

if($user -> is_loggedin()) {
  $user -> redirect("home.php");
}

if(isset($_POST['btn-login'])) {
  $email = test_input($_POST["username_email"]);
  $username = test_input($_POST["username_email"]);
  $password = test_input($_POST["password"]);

  if($user -> login($username, $email, $password)) {
    $user -> redirect("home.php");
  } else {
    $error = "Incorrect Input";
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sign In: Note App</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/application.css">
  </head>
<body>
  <div class="wrapper">
    <div class="container">
      <div class="form-group">
         <h1>Sign In</h1>
         <form method="post">
          <?php
          if(isset($error)) {
            ?>
            <label class="alert"><?php echo $error; ?></label>
            <?php
          }
          ?>
           <input type="text" name="username_email" placeholder="Email or Username" required />
           <input type="password" name="password" placeholder="Password" required />
           <button type="submit" name="btn-login">SIGN IN</button>
           <label>Not registered?  <a href="signup.php">Create an account</a></label>
           <label><a href="#">Forgot your password?</a></label>
         </form>
       </div>
    </div>
  </div>
</body>
</html>
