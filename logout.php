<?php

session_start();
if(!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

session_start();
session_destroy();

header("Location: index.php");

?>