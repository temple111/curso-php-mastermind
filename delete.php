<?php

session_start();
if(!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

require "database.php";

$id = $_GET['id'];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0) {
    http_response_code(404);
    echo("HTTP Error code 404: Page not found");
    return;
}

$contact = $statement->fetch(PDO::FETCH_ASSOC);

if($contact["user_id"] !== $_SESSION["user"]["id"]) {
  http_response_code(403);
  echo("HTTP Error code 403: Not autorized");
  return;
}

$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

$_SESSION["flash"] = ["message" => "Contact {$contact['name']} deleted."];
header("Location: home.php");

return;
?>
