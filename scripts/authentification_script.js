function registerUser() {
    const data = {
        user_name: document.getElementById("user_name").value,
        user_password: document.getElementById("user_password").value,
        user_password_confirm: document.getElementById("user_password_confirm").value,
        user_email: document.getElementById("user_email").value,
        action: document.getElementById("action").value
    };
    
    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/user_authentification.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            if (response["status"] == "Successfully logged in!") {
                location.reload(true);

            } else if (response["status"] == "User registered successfully.") {
                window.location.replace("login_page.php");

            } else document.getElementsByClassName("responseLabel")[0].innerHTML = response["status"];
        }
    }

    XMLHttp.send(dataJSON);
}

function loginUser() {
    const data = {
        user_name: document.getElementById("user_name").value,
        user_password: document.getElementById("user_password").value,
        action: document.getElementById("action").value
    };
    
    const dataJSON = JSON.stringify(data);
    const XMLHttp = new XMLHttpRequest();
    const url = '../server/user_authentification.php';

    XMLHttp.open("POST", url, true);
    XMLHttp.setRequestHeader("Content-Type", "application/json; charset=utf-8");
    XMLHttp.responseType = "json";

    XMLHttp.onreadystatechange = function () {
        if (XMLHttp.readyState === 4 && XMLHttp.status === 200) {
            const response = XMLHttp.response;

            if (response["status"] == "Successfully logged in!") {
                location.reload(true);

            } else if (response["status"] == "User registered successfully.") {
                window.location.replace("login_page.php");

            } else document.getElementsByClassName("responseLabel")[0].innerHTML = response["status"];
        }
    }

    XMLHttp.send(dataJSON);
}