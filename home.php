<?php
include("inc/connection.php");

if(!$user -> is_loggedin()) {
 $user -> redirect("index.php");
}

$id = $_SESSION["user_session"];
$results = $db -> prepare("SELECT * FROM users WHERE id = :id");
$results -> bindParam(":id", $id);
$results -> execute();
$userRow = $results -> fetch(PDO::FETCH_ASSOC);

$noteRow = $note -> show_all();
?>

<!DOCTYPE html>
<html>
<head>
<title>welcome - <?php print($userRow["username"]); ?></title>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/script.js"></script>
<link rel="stylesheet" type="text/css" href="css/application.css">
</head>
<body>
  <div class="top-bar">
    <h2>Welcome <?php print(ucfirst ($userRow["username"])); ?>, you have&nbsp;<span class="notecount"><?php echo count($noteRow); ?></span>&nbsp;notes.</h2>
    <div class="user">
      <div id="dropdown">
        <a href="#"><i class="icon arrow-down"></i><?php print(ucfirst ($userRow["username"])); ?></a>
        <ul>
          <li><a href="#">All Note</a></li>
          <li><a href="#">Edit profile</a></li>
          <li><a href="logout.php?logout=true">Log out</a></li>
        </ul>
      </div>
      <div class="user-image">
        <img src="https://s3.eu-west-2.amazonaws.com/afshin-bucket/avatar/avatar-icon.jpg" width="50" height="50"/>
      </div>
    </div>
  </div>
  <div class="container-flex">
    <div class="column">
      <div class="error"></div>
      <div class="sticky main">
        <form>
          <button id='add-note' class="add">+</button>
  				<textarea id='subject' class="title" placeholder="Enter note title"></textarea>
  				<textarea id='message' class="message" placeholder="Enter note description"></textarea>
        </form>
      </div>
    </div>
    <?php
    if(count($noteRow) > 0) {
      foreach($noteRow as $note) {
        ?>
        <div class='column'>
          <div class="sticky">
            <button class="remove">-</button>
            <h2><?php print($note['subject']); ?></h2>
            <h3><?php print(date("F jS, Y", strtotime($note['published_date'])));?><span><?php print(date("g:ia", strtotime($note['published_date'])));?></span></h3>
            <p><?php print($note['message']); ?></p>
          </div>
        </div>
        <?php
       }
    }
    ?>
  </div>
</body>
</html>
