<?php
session_start();

$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

$user_id = $_SESSION["user_id"];
$log_id = $_POST["log_id"];
$log_type = $_POST["log_type"];
$log_severity = $_POST["log_severity"];
$log_date = $_POST["log_date"];
$log_description = $_POST["log_description"];

if (empty($log_type) || empty($log_severity) || empty($log_date) || empty($log_description)) {
    echo "Empty field detected. Cannot update.";
    exit;
}

$sql_statement = $connection->prepare("UPDATE UserLogs SET log_type = ?, log_severity = ?, log_date = ?, log_content = ? WHERE log_id = ?");
$sql_statement->bind_param("ssssi", $log_type, $log_severity, $log_date, $log_description, $log_id);
$sql_statement->execute();

echo "Log successfully updated.";

mysqli_close($connection);
?>