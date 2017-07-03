<?php
session_start();
include("input_cleaner.php");

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes_app";

try {
  $db = new PDO("mysql:host={$servername};dbname={$database}", $username, $password);
  $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo "Could not connect...";
  echo $e -> getMessage();
  exit;
}

include_once 'user.php';
include_once 'note.php';
$user = new USER($db);
$note = new NOTE($db);
