<?php
include("inc/connection.php");

if($user -> is_loggedin()) {
  $user -> redirect('home.php');
}

if(isset($_POST["btn-signup"])) {
  $username = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $confirm_password = test_input($_POST["confirm_password"]);

if($username == "") {
  $error[] = "username required!";
} else if($email != "" && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
  $error[] = "Enter valid email";
} else if($password == "") {
  $error[] = "password required!";
} else if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,12}$/", $password)) {
  $error[] = "Password must be atleast 6 characters and to be a number, a letter or one of the following: !@#$%";
} else if($password != $confirm_password) {
  $error[] = "Passwords should be same";
} else {
    try {
      $results = $db -> prepare("SELECT username, email FROM users WHERE username = :username OR email = :email");
      $results -> bindParam(":username", $username);
      $results -> bindParam(":email", $email);
      $results -> execute();
      $row = $results -> fetch(PDO::FETCH_ASSOC);

      if($row['username'] == $username) {
        $error[] = "sorry, username $username is already taken!";
      }
      else if($row['email'] == $email) {
        $error[] = "the email $email is already registered, choose another!";
      }
      else
      {
        if($user -> register($username, $email, $password))
        {
          $user -> login($username, $email, $password);
          $user -> redirect('home.php');
        }
      }
     }
     catch(PDOException $e)
     {
        echo $e -> getMessage();
     }
   }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sign up: notes</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/application.css">
  </head>
<body>
  <div class="wrapper">
     <div class="container">
       <div class="form-group">
       <h1>Sign up</h1>
       <form method="post">
         <?php
         if(isset($error)) {
           foreach($error as $error) {
             ?>
             <label class="alert"><?php echo $error; ?></label>
             <?php
            }
          }
          ?>
          <input type="text" name="username" placeholder="Username *" value="<?php if(isset($error)){echo $username;}?>" />
          <input type="text" name="email" placeholder="Email Address *" value="<?php if(isset($error)){echo $email;}?>" />
          <input type="password" name="password" placeholder="Set a Password *" />
          <input type="password" name="confirm_password" placeholder="Confirm Password *" />
          <button type="submit" name="btn-signup">SIGN UP</button>
          <label>Have an account? <a href="index.php">Sign In</a></label>
        </form>
        </div>
       </div>
  </div>
</body>
</html>
