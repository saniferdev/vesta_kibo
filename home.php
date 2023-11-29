<?php
session_start();
if (!empty($_SESSION["username"])) {
    $username 	= $_SESSION["username"];
    $site 		= $_SESSION["site"];
    $groupe 	= $_SESSION["groupe"];
    $type       = $_SESSION["type"];
} else {
    session_unset();
    header("Location: index.php");
}
session_write_close();

require __DIR__ . "/config.php";
require __DIR__ . "/lib/Api.php";

$Api = new API();
$Api->link 	= $link;
$Api->url_soap  = $url_soap;
$Api->login     = $login;
$Api->password  = $password;
$Api->codeLang  = $codeLang;
$Api->poolAlias = $poolAlias;

require __DIR__ . "/theme/kibo/index.php";