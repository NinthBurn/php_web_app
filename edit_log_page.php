<!DOCTYPE html>
<?php
session_start();
require "scripts/script.php";
require "scripts/log_operations.php";
$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

$id = $_GET['log_id'];
$sql_statement = $connection->prepare("SELECT * FROM UserLogs WHERE log_id = (?) and user_id = (?)");
$sql_statement->bind_param("ss", $id, $_SESSION["user_id"]);
$sql_statement->execute();

$query_result = $sql_statement->get_result();

$row = $query_result->fetch_assoc();
mysqli_close($connection);

if(!$row)
echo '<script>
window.location.href="index.php";
alert("Cannot edit a log that was not uploaded by you.");
</script>';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Browser</title>
    <link rel="stylesheet" href="styles/styles.php">
</head>

<body>
    <div class="mainPage" style="flex-direction: column">
        <div class="logBrowserPanel insertLogPanel" style="width: 50%">
            <h2>Update log</h2>
            <form class="insertLogForm" action="" autocomplete="off" method="post" spellcheck="false">
                <?php

                ?>

                <input type="hidden" id="action" value="registerLog">

                <div class="inputField">
                    <label for="log_type">Log Type:</label>
                    <select name="log_type" id="log_type">
                        <option value="event">EVENT</option>
                        <option value="server">SERVER</option>
                        <option value="system">SYSTEM</option>
                    </select>
                </div>

                <div class="inputField">
                    <label for="log_severity">Log Severity:</label>
                    <select name="log_severity" id="log_severity">
                        <option value="notice">NOTICE</option>
                        <option value="debug">DEBUG</option>
                        <option value="warning">WARNING</option>
                        <option value="error">ERROR</option>
                        <option value="critical">CRITICAL</option>
                    </select>
                </div>

                <div class="inputField">
                    <label for="log_date">Log Date:</label>
                    <input type="date" id="log_date" max="<?= date('Y-m-d'); ?>" value="<?= $row["log_date"] ?>" required>
                </div>

                <div class="inputField">
                    <label for="log_description">Log description:</label>
                    <textarea class="logDescriptionInput" id="log_description" required><?= $row["log_content"] ?></textarea>
                </div>

                <div class="inputField">
                    <div class="responseLabel" style="color:aliceblue"></div>
                    <button class="logButtonPanel" type="button" onclick="updateLog(<?= $id ?>)">Update</button>
                </div>

            </form>

            <script>
                $(document).ready(function() {
                    $("#log_severity").val("<?= $row["log_severity"] ?>");
                    $("#log_type").val("<?= $row["log_type"] ?>");

                });

                function returnToIndex(){
                    window.location.href="index.php";
                }
            </script>
        </div>
        <button class="returnButton" type="button" onclick="returnToIndex()">Go back</button>
    </div>
</body>
