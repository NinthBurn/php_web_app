function onDeleteButtonClick(identifier) {
    const data = {
        edit_log: identifier,
    };
    
    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/log_edit.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            if (response["status"] === "is_owner") {
                if (confirm("Are you sure you want to delete this entry?") === true)
                    deleteLog(identifier);
            } else alert("You cannot delete a log you did not upload.");
        }
    }

    XMLHttp.send(dataJSON);
}

function onEditButtonClick(identifier) {
    const data = {
        edit_log: identifier,
    };

    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/log_edit.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            if (response["status"] === "is_owner")
                window.location.href = "edit_log_page.php?log_id=" + identifier;

            else alert("You cannot edit a log you did not upload.");
        }
    }

    XMLHttp.send(dataJSON);
}