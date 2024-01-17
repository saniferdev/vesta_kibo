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

$dossier = "uploads/";
$Api = new API();
$Api->link  = $link;
$Api->link2 = $link2;
$Api->site  = $site;
$Api->user  = $username;


if(isset($_GET["nLigne"])){
    $num     = $_GET["nLigne"];
    $InvE    = $Api->getInvE($num);
    $InvL    = $Api->getInvL($num);
    $session = $Api->getSession($num);

    $file    = $num.'_'.time().'.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$file);

    $fp = fopen('php://output', 'w');

    foreach ($InvE as $row) {
        fwrite($fp, implode(';', $row) . "\r\n");
    }
    foreach ($InvL as $row) {
        fwrite($fp, implode(';', $row) . "\r\n");
    }
    foreach ($session as $row) {
        fwrite($fp, implode(';', $row) . "\r\n");
    }
    
    fclose($fp);
}