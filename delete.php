<?php

session_start();
if(!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

require "database.php";

$id = $_GET['id'];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0) {
    http_response_code(404);
    echo("HTTP Error code 404: Page not found");
    return;
}

$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

header("Location: home.php");
?>
