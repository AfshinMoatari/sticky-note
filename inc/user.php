<?php

class USER {
  private $connection;

  function __construct($db) {
    $this -> connection = $db;
  }

  public function register($username, $email, $password) {

    try {
      $new_password = password_hash($password, PASSWORD_BCRYPT);
      $results = $this -> connection -> prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
      $results -> bindParam(":username", $username);
      $results -> bindParam(":email", $email);
      $results -> bindParam(":password", $new_password);
      $results -> execute();
      return true;
    } catch (Exception $e) {
      echo $e -> getMessage();
      exit;
    }
  }

  public function login($username, $email, $password) {

    try {
      $results = $this -> connection -> prepare("SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1");
      $results -> bindParam(":email", $email);
      $results -> bindParam(":username", $username);
      $results -> execute();
      $userRow = $results -> fetch(PDO::FETCH_ASSOC);
      if ($results -> rowCount() > 0) {
        if (password_verify($password, $userRow['password'])) {
          $_SESSION['user_session'] = $userRow['id'];
          return true;
        } else {
          return false;
        }
      }
    } catch (Exception $e) {
      echo $e -> getMessage();
      exit;
    }
  }

  public function is_loggedin() {
    if(isset($_SESSION["user_session"])) {
      return true;
    }
  }

  public function logout() {
     session_destroy();
     unset($_SESSION["user_session"]);
     return true;
  }
  public function redirect($url) {
    header("Location: $url");
  }
}
?>
