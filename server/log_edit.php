<?php
session_start();
$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

$sql_statement = $connection->prepare("SELECT * FROM UserLogs WHERE log_id = (?) and user_id = (?)");
$sql_statement->bind_param("ss", $_POST["edit_log"], $_SESSION["user_id"]);
$sql_statement->execute();

$query_result = $sql_statement->get_result();

$row = $query_result->fetch_assoc();
mysqli_close($connection);

if (!$row)
    echo 'is_not_owner';
else echo 'is_owner';
?>