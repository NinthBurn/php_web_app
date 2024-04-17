<!DOCTYPE html>
<?php
require "server/user_authentification.php";

if (isset($_SESSION["user_id"])) {
    require "server/config.php";
    $user_id = $_SESSION["user_id"];

    $sql_statement = $connection->prepare("SELECT * FROM Users WHERE user_id = (?)");
    $sql_statement->bind_param("s", $user_id);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result();
    $row = $query_result->fetch_assoc();
    $connection->close();

    if ($row) {
        $user_name = strtoupper($row["user_name"]);
    }
} else {
    Header("Location: login_page.php");
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Browser</title>
    <link rel="stylesheet" href="styles/styles.php">
    <script src="scripts/pagination_scripts.js" defer></script>
    <script src="scripts/log_operations.js" defer></script>
    <script src="scripts/button_scripts.js" defer></script>
</head>

<body>
    <div class="mainPage">
        <!-- left  -->
        <div class="logBrowserLeftColumn">
            <div class="logBrowserPanel userInfoPanel">
                <h2>Log Browser Page</h2>

                <p>Hello <?php echo $user_name; ?>!</p>
                <a href="../server/logout.php">Log out</a>
            </div>

            <div class="logBrowserPanel insertLogPanel">
                <h2>Create a new log</h2>
                <form class="insertLogForm" action="" autocomplete="off" method="post" spellcheck="false">
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
                        <input type="date" id="log_date" max="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="inputField">
                        <label for="log_description">Log description:</label>
                        <textarea class="logDescriptionInput" id="log_description" required></textarea>
                    </div>

                    <div class="inputField">
                        <div class="responseLabel" style="color:aliceblue"></div>
                        <button class="logButtonPanel" type="button" onclick="submitLogData(<?= $user_id ?>)">Register</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- right  -->
        <div class="logBrowserRightColumn" style=" display: flex; justify-content: center; row-gap: 50px">
            <div class="logButtonPanel logBrowserPanel" style="height: 10%;">
                <button type="button" onclick="loadUserLogs(<?= $user_id ?>)">View my logs</button>
                <button type="button" onclick="loadAllLogs()">View all logs</button>

                <label for="searched_severity">Severity:</label>
                <select onchange="handleSelectChange()" style="text-align:center" name="searched_severity" id="searched_severity">
                    <option value="any">ALL</option>
                    <option value="notice">NOTICE</option>
                    <option value="debug">DEBUG</option>
                    <option value="warning">WARNING</option>
                    <option value="error">ERROR</option>
                    <option value="critical">CRITICAL</option>
                </select>

                <label for="searched_type">Type:</label>
                <select onchange="handleSelectChange()" style="text-align:center" name="searched_type" id="searched_type">
                    <option value="any">ALL</option>
                    <option value="event">EVENT</option>
                    <option value="server">SERVER</option>
                    <option value="system">SYSTEM</option>
                </select>
            </div>

            <table class="logTable">
                <thead>
                    <tr class="tableHeader">
                        <th>Author</th>
                        <th>Type</th>
                        <th>Severity</th>
                        <th>Registered on</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


            <div class="logButtonPanel">
                <button type="button" onclick="loadPreviousPage()">Previous page</button>
                <div id="pageIndicator">Page
                    <span id="currentPageIndex"></span> / <span id="totalPageCount"></span>
                </div>
                <button type="button" onclick="loadNextPage()">Next page</button>
            </div>
        </div>
    </div>
</body>

</html>