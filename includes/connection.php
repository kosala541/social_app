<?php
$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "social_db";

$connection = mysqli_connect($server_name, $user_name, $password, $db_name);

if (!$connection) {
    echo "Connection failed!";
}
