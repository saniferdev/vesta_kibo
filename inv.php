<?php
session_start();
if (!empty($_SESSION["username"])) {
    $username 	= $_SESSION["username"];
    $site 		= $_SESSION["site"];
    $groupe     = $_SESSION["groupe"];
} else {
    session_unset();
    header("Location: index.php");
}
session_write_close();

require __DIR__ . "/config.php";
require __DIR__ . "/lib/Api.php";
require __DIR__ . "/theme/kibo/index.php";

