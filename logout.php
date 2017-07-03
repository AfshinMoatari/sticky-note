<?php
	include("inc/connection.php");

	if($user -> is_loggedin() != "") {
		$user -> redirect('home.php');
	}

	if(isset($_GET['logout']) && $_GET['logout'] == "true") {
		$user -> logout();
		$user -> redirect('index.php');
	}
