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

$Api                = new API();
$Api->link 	        = $link;
$Api->link2         = $link2;
$Api->url_soap      = $url_soap;
$Api->login         = $login;
$Api->password      = $password;
$Api->codeLang      = $codeLang;
$Api->poolAlias     = $poolAlias;
$Api->site          = $site;
$Api->codeFamille   = $codeFamille;

require __DIR__ . "/theme/kibo/sortie.php";