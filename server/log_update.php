<?php
session_start();
$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_SESSION["user_id"];
$log_id = $_POST["log_id"];
$log_type = $_POST["log_type"];
$log_severity = $_POST["log_severity"];
$log_date = $_POST["log_date"];
$log_description = $_POST["log_description"];


if (empty($log_type) || empty($log_severity) || empty($log_date) || empty($log_description)) {
    $status = ["status" => "Empty field detected. Cannot update."];
    echo json_encode($status);    
    exit;
}

require "config.php";

$sql_statement = $connection->prepare("UPDATE UserLogs SET log_type = ?, log_severity = ?, log_date = ?, log_content = ? WHERE log_id = ?");
$sql_statement->bind_param("ssssi", $log_type, $log_severity, $log_date, $log_description, $log_id);
$sql_statement->execute();

mysqli_close($connection);

$status = ["status" => "Log successfully updated."];
echo json_encode($status);
?>