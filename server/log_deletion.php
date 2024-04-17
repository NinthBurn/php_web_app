<?php
require "config.php";

$_POST = json_decode(file_get_contents('php://input'), true);
$log_id = $_POST["log_id"];

$sql_statement = $connection->prepare("DELETE FROM UserLogs WHERE log_id = $log_id");
$sql_statement->execute();

mysqli_close($connection);

$status = ["status" => "Log successfully deleted."];
echo json_encode($status);
?>