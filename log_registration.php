
<?php
// address / DB user name / DB password / DB name
$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

if (isset($_POST["action"])) {
    if ($_POST["action"] == "registerLog")
        registerLog();
}

function registerLog()
{
    global $connection;

    $user_id = $_POST["user_id"];
    $log_type = $_POST["log_type"];
    $log_severity = $_POST["log_severity"];
    $log_date = $_POST["log_date"];
    $log_description = $_POST["log_description"];

    if (empty($log_type) || empty($log_severity) || empty($log_date) || empty($log_description)) {
        echo "Empty field detected. Cannot register.";
        exit;
    }

    $sql_statement = $connection->prepare("INSERT INTO UserLogs (user_id, log_type, log_severity, log_date, log_content) VALUES (?, ?, ?, ?, ?)");
    $sql_statement->bind_param("issss", $user_id, $log_type, $log_severity, $log_date, $log_description);
    $sql_statement->execute();

    echo "Log successfully registered.";
}
