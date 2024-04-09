<!DOCTYPE html>
<?php
require "user_authentification.php";
require "script.php";

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    $sql_statement = $connection->prepare("SELECT * FROM Users WHERE user_id = (?)");
    $sql_statement->bind_param("s", $user_id);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result();
    $row = $query_result->fetch_assoc();

    if ($row) {
        $user_name = strtoupper($row["user_name"]);
    }
}else{
    Header("Location: login_page.php");
}

require "pagination_scripts.php";
require "log_operations.php";
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Browser</title>
    <link rel="stylesheet" href="styles/styles.php">
</head>

<body>
    <div class="mainPage">
        <?php include("left_column.php");?>
        
        <?php include("right_column.php");?>
        <script defer>
            initialPageLoad();
        </script>
    </div>
</body>

</html>