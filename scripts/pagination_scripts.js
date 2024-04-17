let author_id = 0, searched_type = "any", searched_severity = "any";
const tableBody = document.getElementsByTagName("tbody")[0];
const currentPageIndexElement = document.getElementById("currentPageIndex");
const totalPageCountElement = document.getElementById("totalPageCount");

function initialPageLoad() {
    author_id = 0;
    searched_severity = "any";
    searched_type = "any";
    loadPage(1);
}

function loadPreviousPage() {
    const previousPage = parseInt(document.getElementById("currentPageIndex").innerText) - 1;

    if (previousPage < 1) {
        console.log("No pages left");

    } else {
        loadPage(previousPage);
    }
}

function loadNextPage() {
    const nextPage = parseInt(document.getElementById("currentPageIndex").innerText) + 1;

    if (nextPage > document.getElementById("totalPageCount").innerText) {
        console.log("No pages left");

    } else {
        loadPage(nextPage);
    }
}

function loadUserLogs(user_id) {
    author_id = user_id;
    searched_severity = document.getElementById("searched_severity").value;
    searched_type = document.getElementById("searched_type").value;
    loadPage(1);
}

function loadAllLogs() {
    author_id = 0;
    searched_severity = document.getElementById("searched_severity").value;
    searched_type = document.getElementById("searched_type").value;
    loadPage(1);
}

function handleSelectChange() {
    searched_severity = document.getElementById("searched_severity").value;
    searched_type = document.getElementById("searched_type").value;
    loadPage(1);
}

function createTableRow(data) {
    if (data.length === 0) {
        const emptyRow = document.createElement("tr");

        for (i = 0; i < 6; ++i)
            emptyRow.appendChild(document.createElement("td"));

        return emptyRow;
    }

    const row = document.createElement("tr");
    const properties = ["log_author", "log_type", "log_severity", "log_date", "log_content"];

    properties.forEach((property) => {
        const newColumn = document.createElement("td");

        if (property === "log_type" || property === "log_severity")
            newColumn.innerHTML = data[property].toUpperCase();
        else newColumn.innerHTML = data[property];

        row.appendChild(newColumn);
    })

    const actionColumn = document.createElement("td");
    actionColumn.innerHTML =
        '<div style="display: flex; justify-content: space-evenly; width: 100%">'
        + '<button style="width: 60px" type="button" onclick="onDeleteButtonClick(' + data["log_id"] + ')">Delete</button>'
        + '<button style="width: 60px" type="button" onclick="onEditButtonClick(' + data["log_id"] + ')">Edit</button>'
        + '</div>';

    row.appendChild(actionColumn);

    return row;
}

function createTableRows(data) {
    const rows = data;
    let row_count = 0;
    tableBody.innerHTML = "";

    rows.forEach((row) => {
        tableBody.appendChild(createTableRow(row));
        row_count++;
    })

    while (row_count < 4) {
        tableBody.appendChild(createTableRow([]));
        row_count++;
    }
}

function loadPage(page) {
    const data = {
        page: page,
        author_id: author_id,
        searched_type: searched_type,
        searched_severity: searched_severity,
    };

    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/fetch_page.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            currentPageIndexElement.innerHTML = page;
            totalPageCountElement.innerHTML = response.pages;

            if (page > response.pages)
                loadPage(page - 1);

            createTableRows(response.rows);
        }
    }
    XMLHttp.send(dataJSON);
}

initialPageLoad();