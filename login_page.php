<?php 
require "server/user_authentification.php";
if(isset($_SESSION["user_id"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.php">
    <title>Log Browser</title>
</head>
<body>
    <div class="loginPanel">
        <div class="loginForm">
            <h1>Login Pages</h1>
            <form autocomplete="off" action="" method="post" >
                <input type="hidden" id="action" value="login"/>

                <label for="user_name">User Name:</label><br><br>
                <input type="text" name="user_name" id="user_name" required /><br>
                <br>

                <label for="user_password">Password:</label><br><br>
                <input type="password" name="user_password" id="user_password" required /><br>
                <br>
                
                <button type="button" onclick="submitData();">Login</button>
                <br><br>
            </form>
            <div class="responseLabel"></div>
            <div><br><br></div>
        </div>
        <div>
            <br>
            Don't have an account? Register <a href="register_page.php">here</a>.
        </div>
    </div>
    <?php require "scripts/script.php"?>
</body>
</html>
