<div class="logBrowserLeftColumn">
    <div class="logBrowserPanel userInfoPanel">
        <h2>Log Browser Page</h2>

        <p>Hello <?php echo $user_name; ?>!</p>
        <a href="logout.php">Log out</a>
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