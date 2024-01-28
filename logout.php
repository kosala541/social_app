<?php
session_start();
require "includes/connection.php";

if (isset($_SESSION["user"])) {

    $_SESSION["user"] = null;
    session_destroy();

    header("Location:./");
}
