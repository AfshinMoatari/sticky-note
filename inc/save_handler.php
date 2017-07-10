<?php
include("connection.php");

if(isset($_POST['subject'], $_POST["message"])) {
  $subject = test_input($_POST["subject"]);
  $message = test_input($_POST["message"]);
  $new_note = $note -> save($subject, $message);
}
echo json_encode($new_note);
