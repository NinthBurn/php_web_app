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

<script>
    function onEditButtonClick(identifier){
        window.location.href = "edit_log_page.php?log_id=" + identifier;
    }
</script>