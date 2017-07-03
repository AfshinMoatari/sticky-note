<?php

class NOTE {
  private $connection;

  function __construct($db) {
    $this -> connection = $db;
  }

  public function show_all() {
    $id = $_SESSION['user_session'];
    try {
      $results = $this -> connection -> prepare("SELECT users.username, notes.subject, notes.message, notes.published_date FROM users JOIN notes ON users.id = notes.user_id AND notes.user_id = :id ORDER BY notes.published_date DESC");
      $results -> bindParam(":id", $id);
      $results -> execute();
      $noteRow = $results -> fetchAll(PDO::FETCH_ASSOC);
      return $noteRow;
    } catch (Exception $e) {
      echo $e -> getMessage();
      exit;
    }
  }

  public function add($subject, $message) {
    $id = $_SESSION['user_session'];
    try {
      $results = $this -> connection -> prepare("INSERT INTO notes(subject, message, user_id)
      VALUES(:subject, :message, :id)");
      $results -> bindParam(":subject", $subject);
      $results -> bindParam(":message", $message);
      $results -> bindParam(":id", $id);
      $results -> execute();
      $insert_id = $this -> connection -> lastInsertId();
      try {
        $results = $this -> connection -> prepare("SELECT subject, message, published_date, id FROM notes WHERE id = :insert_id");
        $results -> bindParam(":insert_id", $insert_id);
        $results -> execute();
        $addRow = $results -> fetch(PDO::FETCH_ASSOC);
        return $addRow;
      } catch (Exception $e) {
        echo $e -> getMessage();
        exit;
      }
    } catch (Exception $e) {
      echo $e -> getMessage();
      exit;
    }
  }

}
?>
