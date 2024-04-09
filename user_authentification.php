<?php
session_start();

// address / DB user name / DB password / DB name
$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

if (isset($_POST["action"])) {
    if ($_POST["action"] == "register")
        registerUser();

    else if ($_POST["action"] == "login")
        loginUser();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function registerUser()
{
    global $connection;

    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
    $user_password_confirm = $_POST["user_password_confirm"];
    $user_email = $_POST["user_email"];

    if (empty($user_email) || empty($user_name) || empty($user_password)) {
        echo "Empty field detected. Cannot register.";
        exit;
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. ";
        exit;
    }

    if ($user_password != $user_password_confirm) {
        echo "Password fields are different. ";
        exit;
    }

    $user_name = test_input($user_name);

    if (!preg_match("/^[a-zA-Z0-9-_]*$/", $user_name)) {
        echo "Only letters, digits, and underlines are allowed. ";
        exit;
    }

    $sql_statement = $connection->prepare("SELECT COUNT(*) FROM Users WHERE user_name = (?)");
    $sql_statement->bind_param("s", $user_name);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result()->fetch_all()[0][0];

    if ($query_result > 0) {
        echo "Username has been taken. ";
        exit;
    }

    $sql_statement = $connection->prepare("SELECT COUNT(*) FROM Users WHERE user_email = (?)");
    $sql_statement->bind_param("s", $user_email);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result()->fetch_all()[0][0];

    if ($query_result > 0) {
        echo "Email is already used by another account. ";
        exit;
    }

    if (empty($result)) {
        $sql_statement = $connection->prepare("INSERT INTO Users (user_name, user_password, user_email) VALUES (?, ?, ?)");
        $sql_statement->bind_param("sss", $user_name, $user_password, $user_email);
        $sql_statement->execute();

        echo "User registered successfully.";
        exit;
    }

    echo $result;
}

function loginUser()
{
    global $connection;

    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];

    if (empty($user_name) || empty($user_password)) {
        echo "Empty field detected. Cannot login.";
        exit;
    }

    $sql_statement = $connection->prepare("SELECT * FROM Users WHERE user_name = (?)");
    $sql_statement->bind_param("s", $user_name);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result();

    if ($query_result->num_rows == 1) {
        $row = $query_result->fetch_assoc();

        if ($row["user_password"] == $user_password) {
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];

            echo "Successfully logged in!";
        } else {
            echo "Wrong password.";
        }
    } else echo "User not found.";
}