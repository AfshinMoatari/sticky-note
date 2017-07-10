<?php
include("connection.php");

if(isset($_POST['note_id'])) {
  $note_id = $note -> erase($_POST['note_id']);
}
echo $note_id;
