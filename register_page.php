<?php 
require "user_authentification.php";
if(isset($_SESSION["user_id"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/styles.php">

</head>
<body>
    <div class="loginPanel">
        <div class="loginForm">
            <h1>Register Page</h1>
            <form action="" autocomplete="off" method="post" >
                <input type="hidden" id="action" value="register">

                <label for="user_name">User Name:</label><br><br>
                <input type="text" id="user_name" required><br>
                <br>
                
                <label for="user_password">Password:</label><br><br>
                <input type="password" id="user_password" required><br>
                <br>

                <label for="user_password_confirm">Confirm password:</label><br><br>
                <input type="password" id="user_password_confirm" required><br>
                <br>

                <label for="user_email">Email:</label><br><br>
                <input type="email" id="user_email" required><br>
                <br>
                
                
                <button type="button" onclick="submitData()">Register</button>
                <br><br>
                <div class="responseLabel"></div>
                <br>
            </form>
            
        </div>
    </div>
    <?php require "script.php"?>
</body>
</html>
