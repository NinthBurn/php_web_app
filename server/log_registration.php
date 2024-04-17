
<?php
// address / DB user name / DB password / DB name
$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST["action"])) {
    if ($_POST["action"] == "registerLog")
        registerLog();
}

function registerLog()
{
    $status = ["status" => "s"];
    $user_id = $_POST["user_id"];
    $log_type = $_POST["log_type"];
    $log_severity = $_POST["log_severity"];
    $log_date = $_POST["log_date"];
    $log_description = $_POST["log_description"];

    if (empty($log_type) || empty($log_severity) || empty($log_date) || empty($log_description)) {
        $status["status"] = "Empty field detected. Cannot register.";
        echo json_encode($status);
        exit;
    }

    require "config.php";

    $sql_statement = $connection->prepare("INSERT INTO UserLogs (user_id, log_type, log_severity, log_date, log_content) VALUES (?, ?, ?, ?, ?)");
    $sql_statement->bind_param("issss", $user_id, $log_type, $log_severity, $log_date, $log_description);
    $sql_statement->execute();
    
    $connection->close();

    $status["status"] = "Log successfully registered.";
    echo json_encode($status);
}
