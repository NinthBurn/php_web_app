<?php
session_start();
require "config.php";

$_POST = json_decode(file_get_contents('php://input'), true);

$sql_statement = $connection->prepare("SELECT * FROM UserLogs WHERE log_id = (?) and user_id = (?)");
$sql_statement->bind_param("ss", $_POST["edit_log"], $_SESSION["user_id"]);
$sql_statement->execute();

$query_result = $sql_statement->get_result();

$row = $query_result->fetch_assoc();
mysqli_close($connection);

$status["status"] = "";

if (!$row)
    $status["status"] = 'is_not_owner';
else $status["status"] = 'is_owner';

echo json_encode($status);
?>