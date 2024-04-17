function submitLogData(user_id) {
    const data = {
        user_id: user_id,
        log_type: document.getElementById("log_type").value,
        log_severity: document.getElementById("log_severity").value,
        log_date: document.getElementById("log_date").value,
        log_description: document.getElementById("log_description").value,
        action: document.getElementById("action").value
    }

    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/log_registration.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            if (response["status"] == "Log successfully registered.") {
                loadPage(document.getElementById("currentPageIndex").innerHTML);
            }

            document.getElementsByClassName("responseLabel")[0].innerHTML = response["status"];
        }
    }

    XMLHttp.send(dataJSON);
}

function deleteLog(identifier) {
    const data = {
        log_id: identifier
    };

    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/log_deletion.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            document.getElementsByClassName("responseLabel")[0].innerHTML = response["status"];
            loadPage(document.getElementById("currentPageIndex").innerHTML);
        }
    }

    XMLHttp.send(dataJSON);
}

function updateLog(identifier) {
    const data = {
        log_id: identifier,
        log_type: document.getElementById("log_type").value,
        log_severity: document.getElementById("log_severity").value,
        log_date: document.getElementById("log_date").value,
        log_description: document.getElementById("log_description").value,
        action: document.getElementById("action").value
    };

    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/log_update.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            document.getElementsByClassName("responseLabel")[0].innerHTML = response["status"];
        }
    }

    XMLHttp.send(dataJSON);
}