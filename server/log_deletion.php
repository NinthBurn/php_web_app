<?php
$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

$log_id = $_POST["log_id"];

$sql_statement = $connection->prepare("DELETE FROM UserLogs WHERE log_id = $log_id");
$sql_statement->execute();

mysqli_close($connection);
?>