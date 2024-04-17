<?php 
// address / DB user name / DB password / DB name
$config = parse_ini_file('.env');
$connection = new mysqli($config["db_address"], $config["db_user"], $config["db_password"], $config["db_name"]) or die("Connection failed:" . mysqli_connect_error());

?>