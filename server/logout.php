<?php
require "user_authentification.php";
$_SESSION = [];
session_unset();
session_destroy();
header("Location: ../login_page.php");
?>