<?php
session_start();
$_POST = json_decode(file_get_contents('php://input'), true);

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
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
    $user_password_confirm = $_POST["user_password_confirm"];
    $user_email = $_POST["user_email"];

    if (empty($user_email) || empty($user_name) || empty($user_password)) {
        $status["status"] = "Empty field detected. Cannot register.";
        echo json_encode($status);
        exit;
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $status["status"] = "Invalid email format.";
        echo json_encode($status);
        exit;
    }

    if ($user_password != $user_password_confirm) {
        $status["status"] = "Password fields are different.";
        echo json_encode($status);
        exit;
    }

    $user_name = test_input($user_name);

    if (!preg_match("/^[a-zA-Z0-9-_]*$/", $user_name)) {
        $status["status"] = "Only letters, digits, and underlines are allowed.";
        echo json_encode($status);
        exit;
    }

    require "config.php";

    $sql_statement = $connection->prepare("SELECT COUNT(*) FROM Users WHERE user_name = (?)");
    $sql_statement->bind_param("s", $user_name);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result()->fetch_all()[0][0];

    if ($query_result > 0) {
        $status["status"] = "Username has been taken.";
        echo json_encode($status);
        $connection->close();
        exit;
    }

    $sql_statement = $connection->prepare("SELECT COUNT(*) FROM Users WHERE user_email = (?)");
    $sql_statement->bind_param("s", $user_email);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result()->fetch_all()[0][0];

    if ($query_result > 0) {
        $status["status"] = "Email is already used by another account.";
        echo json_encode($status);
        $connection->close();
        exit;
    }

    if (empty($result)) {
        $sql_statement = $connection->prepare("INSERT INTO Users (user_name, user_password, user_email) VALUES (?, ?, ?)");
        $sql_statement->bind_param("sss", $user_name, $user_password, $user_email);
        $sql_statement->execute();

        $connection->close();

        $status["status"] = "User registered successfully.";
        echo json_encode($status);
        exit;
    }
}

function loginUser()
{
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];

    if (empty($user_name) || empty($user_password)) {
        $status["status"] = "Empty field detected. Cannot login.";
        echo json_encode($status);
        exit;
    }

    require "config.php";

    $sql_statement = $connection->prepare("SELECT * FROM Users WHERE user_name = (?)");
    $sql_statement->bind_param("s", $user_name);
    $sql_statement->execute();

    $query_result = $sql_statement->get_result();

    if ($query_result->num_rows == 1) {
        $row = $query_result->fetch_assoc();

        if ($row["user_password"] == $user_password) {
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];

            $status["status"] = "Successfully logged in!";
            echo json_encode($status);
        } else {
            $status["status"] = "Wrong password.";
            echo json_encode($status);
        }
    } else {
        $status["status"] = "User not found.";
        echo json_encode($status);
    }

    $connection->close();
}